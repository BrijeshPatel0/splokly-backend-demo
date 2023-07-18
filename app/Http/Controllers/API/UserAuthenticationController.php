<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Mail\Auth\ResetPassword;
use App\Models\PasswordResetToken;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Twilio\Rest\Client;

class UserAuthenticationController extends Controller
{

    private UserRepositoryInterface $orderRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendOTP(Request $request): JsonResponse
    {
        $country_code = $request->country_code;
        $mobile = $request->mobile;
        $device_id = $request->device_id;
        $ip_address = $request->ip_address;
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env("TWILIO_AUTH_TOKEN");
        $service_id = env("TWILIO_SERVICE_ID");
        $twilio = new Client($sid, $token);

        $response = $twilio->verify->v2->services($service_id)->verifications->create(
            'whatsapp:'.$country_code.$mobile,
            'whatsapp',
            [
                'rateLimit' => '{"end_user_ip_address": '.$ip_address .', "end_user_divice_id": ' . $device_id . '}'

            ]
        );
        // Handle the response here
        if ($response->status === 'pending') {
            return response()->json(['success' => true,'message' => 'OTP send successfully']);
        } else {
            return response()->json(['success' => false,'error' => 'Error sending verification code'], 500);
        }


    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $this->userRepository->createUserOrUpdate($validated);

        $user->assignRole($validated['role']);

        # And make sure to use the plainTextToken property
        # Since this will return us the plain text token and then store the hashed value in the database

        return $this->respondWithSuccess(new UserResource($user));
    }

    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->respondUnAuthenticated(__('Invalid login details'));
        }

        $user = $this->userRepository->getUserByEmail($request->email);

        # Delete the existing tokens from the database and create a new one
        auth()->user()->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->respondWithSuccess([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->respondWithSuccess(['message' => 'Logged out successfully']);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->respondWithSuccess(['status' => __($status)])
            : $this->respondError(__($status));
    }

    public function resetForm(Request $request, $token): JsonResponse|ViewFactory|View
    {

        $validated = $request->validate(['email' => 'required|email']);

        $hashedToken = PasswordResetToken::where('email', $validated['email'])->first();
        if (!Hash::check($token, $hashedToken->token)) {
            return $this->respondUnAuthenticated(__('Reset password token is not valid'));
        }

        $role = $this->userRepository->getRoleByEmail($validated['email']);

        return view('auth.reset-password', ['token' => $token, 'email' => $validated['email'], 'role' => $role]);
    }

    public function resetPassword(ResetPasswordRequest $request): string
    {
        $validated = $request->validated();

        $status = Password::reset(
            $validated,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $response = $status === Password::PASSWORD_RESET
            ? $this->respondWithSuccess(['status' => __($status)])
            : $this->respondError(__($status));

        return $response->getContent();
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse|RedirectResponse
     */
    public function redirectToProvider(string $provider): JsonResponse|RedirectResponse
    {
        $validated = $this->validateProvider($provider);

        if (!is_null($validated)) {
            return $validated;
        }

        $url = Socialite::driver($provider)
            ->stateless()
            ->scopes(['openid'])
            ->redirect()->getTargetUrl();

        return $this->respondWithSuccess(['redirect_url' => $url]);
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback(string $provider): JsonResponse
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $userCreated = $this->userRepository->getUserOrCreate($user);
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );
        $token = $userCreated->createToken('auth_token')->plainTextToken;

        return $this->respondWithSuccess([
            'user' => new UserResource($userCreated),
            'token' => $token
        ]);
    }

    /**
     * @param $provider
     * @return JsonResponse|null
     */
    protected function validateProvider(string $provider): JsonResponse|null
    {
        if (!in_array($provider, array_keys(config('services')))) {
            return response()->json(['error' => "Please login using " . implode(', ', array_keys(config('services')))], 422);
        }

        return null;
    }
}
