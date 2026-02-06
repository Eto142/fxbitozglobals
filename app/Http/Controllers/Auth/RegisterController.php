<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Http;


class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'account_type' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'country' => 'required|string',
            'terms' => 'accepted',
            'third_first_name' => ['nullable', 'string', 'max:255'],
            'third_last_name' => ['nullable', 'string', 'max:255'],
            'third_phone' => ['nullable', 'string', 'max:20'],
            'third_address' => ['nullable', 'string', 'max:255'],
            
        // CAPTCHA field required
        'g-recaptcha-response' => 'required',
    ], [
        'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            
            
        ]);
        
    }
    
    
  
public function register(Request $request)
{
    
      // Honeypot trap
    if (!empty($request->website_url)) {
        return back()->withErrors(['error' => 'Bot detected.'])->withInput();
    }

    
    // Validate form input first
    $this->validator($request->all())->validate();

    // Verify Google reCAPTCHA
    $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => env('RECAPTCHA_SECRET_KEY'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ])->json();

    if (!($verify['success'] ?? false)) {
        return back()
            ->withErrors(['g-recaptcha-response' => 'ReCAPTCHA validation failed.'])
            ->withInput();
    }

    // If captcha passes → create user
    $user = $this->create($request->all());

    $this->guard()->login($user);

    return redirect($this->redirectPath());
}





    /**
     * Show the registration form with referral link handling.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        $referred_by = null;

        // Check if there's a referral code in the URL query parameters
        if ($request->has('ref')) {
            $referred_by = User::where('referral_code', $request->query('ref'))->first();
        }

        return view('auth.register', ['referred_by' => $referred_by]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Auto-generate unique account number
        do {
            $account_number =  mt_rand(1000000000, 9999999999);
        } while (User::where('account_number', $account_number)->exists());



        // Get currency symbol based on country
        $currencySymbol = $this->getCurrencySymbol($data['country']);

        // Create a new user record in the database
        $user = User::create([
            'account_type' => $data['account_type'],
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'country' => $data['country'],
            'ref_by' => $data['ref_by'] ?? null, // Store referral ID if present
            'third_first_name' => $data['third_first_name'] ?? null,
            'third_last_name' => $data['third_last_name'] ?? null,
            'third_phone' => $data['third_phone'] ?? null,
            'third_address' => $data['third_address'] ?? null,
            'account_number'     => $account_number,
            'currency_symbol' => $currencySymbol,
        ]);

        // Generate a verification code and set its expiration
        // $verificationCode = rand(1000, 9999);
        // $user->update([
        //     'verification_code' => $verificationCode,
        //     'verification_expiry' => now()->addMinutes(10),
        // ]);

        // Prepare email content
        $emailContent = "
    <p>Thank you for registering on our platform. Below are your login details:</p>
    <ul>
        <li><strong>Email ID:</strong> {$data['email']}</li>
       <li><strong>Password:</strong> {$data['password']}</li>

    </ul>
    <p>We recommend you keep this information safe and secure.</p>
    <p>Best Regards,<br> The Team</p>
        ";

        // Send verification email (uncomment this to enable email sending)
        // Mail::to($user->email)->send(new VerificationEmail($emailContent));

        Mail::to($user->email)->send(new WelcomeEmail($emailContent));

        return $user;
    }
    
    
    private function getCurrencySymbol($country)
{
    $countryCurrencyMap = [
        'Afghanistan' => '؋',
        'Albania' => 'L',
        'Algeria' => 'د.ج',
        'Andorra' => '€',
        'Angola' => 'Kz',
        'Antigua and Barbuda' => '$',
        'Argentina' => '$',
        'Armenia' => '֏',
        'Australia' => '$',
        'Austria' => '€',
        'Azerbaijan' => '₼',
        'Bahamas' => '$',
        'Bahrain' => '.د.ب',
        'Bangladesh' => '৳',
        'Barbados' => '$',
        'Belarus' => 'Br',
        'Belgium' => '€',
        'Belize' => '$',
        'Benin' => 'CFA',
        'Bhutan' => 'Nu.',
        'Bolivia' => 'Bs.',
        'Bosnia and Herzegovina' => 'KM',
        'Botswana' => 'P',
        'Brazil' => 'R$',
        'Brunei' => '$',
        'Bulgaria' => 'лв',
        'Burkina Faso' => 'CFA',
        'Burundi' => 'FBu',
        'Cabo Verde' => '$',
        'Cambodia' => '៛',
        'Cameroon' => 'FCFA',
        'Canada' => '$',
        'Central African Republic' => 'FCFA',
        'Chad' => 'FCFA',
        'Chile' => '$',
        'China' => '¥',
        'Colombia' => '$',
        'Comoros' => 'CF',
        'Congo (Congo-Brazzaville)' => 'FCFA',
        'Congo (Democratic Republic of the)' => 'FC',
        'Costa Rica' => '₡',
        'Croatia' => 'kn',
        'Cuba' => '$',
        'Cyprus' => '€',
        'Czechia (Czech Republic)' => 'Kč',
        'Denmark' => 'kr',
        'Djibouti' => 'Fdj',
        'Dominica' => '$',
        'Dominican Republic' => '$',
        'Ecuador' => '$',
        'Egypt' => '£',
        'El Salvador' => '$',
        'Equatorial Guinea' => 'FCFA',
        'Eritrea' => 'Nfk',
        'Estonia' => '€',
        'Eswatini (fmr. Swaziland)' => 'L',
        'Ethiopia' => 'Br',
        'Fiji' => '$',
        'Finland' => '€',
        'France' => '€',
        'Gabon' => 'FCFA',
        'Gambia' => 'D',
        'Georgia' => '₾',
        'Germany' => '€',
        'Ghana' => '₵',
        'Greece' => '€',
        'Grenada' => '$',
        'Guatemala' => 'Q',
        'Guinea' => 'FG',
        'Guinea-Bissau' => 'CFA',
        'Guyana' => '$',
        'Haiti' => 'G',
        'Honduras' => 'L',
        'Hungary' => 'Ft',
        'Iceland' => 'kr',
        'India' => '₹',
        'Indonesia' => 'Rp',
        'Iran' => '﷼',
        'Iraq' => 'ع.د',
        'Ireland' => '€',
        'Israel' => '₪',
        'Italy' => '€',
        'Jamaica' => '$',
        'Japan' => '¥',
        'Jordan' => 'د.ا',
        'Kazakhstan' => '₸',
        'Kenya' => 'KSh',
        'Kiribati' => '$',
        'Korea (North)' => '₩',
        'Korea (South)' => '₩',
        'Kuwait' => 'د.ك',
        'Kyrgyzstan' => 'с',
        'Laos' => '₭',
        'Latvia' => '€',
        'Lebanon' => 'ل.ل',
        'Lesotho' => 'L',
        'Liberia' => '$',
        'Libya' => 'ل.د',
        'Liechtenstein' => 'CHF',
        'Lithuania' => '€',
        'Luxembourg' => '€',
        'Madagascar' => 'Ar',
        'Malawi' => 'MK',
        'Malaysia' => 'RM',
        'Maldives' => 'Rf',
        'Mali' => 'CFA',
        'Malta' => '€',
        'Marshall Islands' => '$',
        'Mauritania' => 'UM',
        'Mauritius' => '₨',
        'Mexico' => '$',
        'Micronesia' => '$',
        'Moldova' => 'L',
        'Monaco' => '€',
        'Mongolia' => '₮',
        'Montenegro' => '€',
        'Morocco' => 'د.م.',
        'Mozambique' => 'MT',
        'Myanmar (Burma)' => 'K',
        'Namibia' => '$',
        'Nauru' => '$',
        'Nepal' => '₨',
        'Netherlands' => '€',
        'New Zealand' => '$',
        'Nicaragua' => 'C$',
        'Niger' => 'CFA',
        'Nigeria' => '₦',
        'North Macedonia' => 'ден',
        'Norway' => 'kr',
        'Oman' => 'ر.ع.',
        'Pakistan' => '₨',
        'Palau' => '$',
        'Palestine State' => '₪',
        'Panama' => 'B/.',
        'Papua New Guinea' => 'K',
        'Paraguay' => '₲',
        'Peru' => 'S/',
        'Philippines' => '₱',
        'Poland' => 'zł',
        'Portugal' => '€',
        'Qatar' => 'ر.ق',
        'Romania' => 'lei',
        'Russia' => '₽',
        'Rwanda' => 'FRw',
        'Saint Kitts and Nevis' => '$',
        'Saint Lucia' => '$',
        'Saint Vincent and the Grenadines' => '$',
        'Samoa' => 'T',
        'San Marino' => '€',
        'Sao Tome and Principe' => 'Db',
        'Saudi Arabia' => 'ر.س',
        'Senegal' => 'CFA',
        'Serbia' => 'дин',
        'Seychelles' => '₨',
        'Sierra Leone' => 'Le',
        'Singapore' => '$',
        'Slovakia' => '€',
        'Slovenia' => '€',
        'Solomon Islands' => '$',
        'Somalia' => 'Sh',
        'South Africa' => 'R',
        'South Sudan' => '£',
        'Spain' => '€',
        'Sri Lanka' => 'Rs',
        'Sudan' => '£',
        'Suriname' => '$',
        'Sweden' => 'kr',
        'Switzerland' => 'CHF',
        'Syria' => '£',
        'Taiwan' => 'NT$',
        'Tajikistan' => 'ЅМ',
        'Tanzania' => 'TSh',
        'Thailand' => '฿',
        'Timor-Leste' => '$',
        'Togo' => 'CFA',
        'Tonga' => 'T$',
        'Trinidad and Tobago' => '$',
        'Tunisia' => 'د.ت',
        'Turkey' => '₺',
        'Turkmenistan' => 'T',
        'Tuvalu' => '$',
        'Uganda' => 'USh',
        'Ukraine' => '₴',
        'United Arab Emirates' => 'د.إ',
        'United Kingdom' => '£',
        'United States' => '$',
        'Uruguay' => '$',
        'Uzbekistan' => 'soʻm',
        'Vanuatu' => 'VT',
        'Vatican City' => '€',
        'Venezuela' => 'Bs.',
        'Vietnam' => '₫',
        'Yemen' => '﷼',
        'Zambia' => 'ZK',
        'Zimbabwe' => '$',
    ];

    return $countryCurrencyMap[$country] ?? '$'; // Default to $ if country not found
}
}
