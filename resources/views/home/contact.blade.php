@include('home.header');

<section class="page-intro page-intro-contacts">
  <div class="container container-large">
    <h1 class="page-intro__title">Our<br> contacts </h1>
<style>
  .contact-container {
    max-width: 900px;
    margin: 30px auto;
    text-align: center;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  }

  .contact-row {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 25px;
  }

  .contact-item {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #212529;
    font-size: 16px;
    gap: 8px;
    transition: all 0.3s ease;
  }

  .contact-item a {
    color: #212529;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .contact-item a:hover {
    color: #007bff;
    text-decoration: underline;
  }
  
 

  .contact-icon {
    color: #007bff;
    font-size: 18px;
  }

  /* Responsive layout */
  @media (max-width: 576px) {
    .contact-row {
      flex-direction: column;
      gap: 15px;
    }
  }
</style>

<div class="contact-container">
  <div class="contact-row">
    <div class="contact-item">
      <span class="contact-icon">📧</span>
      <a href="mailto:support@fxbitozglobal.com" style ="color:white">support@fxbitozglobal.com</a>
    </div>
    <div class="contact-item">
      <span class="contact-icon">📞</span>
      <a href="tel:+16125249263" style ="color:white">+1 (612) 524-9263</a>
    </div>
  </div>
</div>
  ‬

  </div>
</section>
<section class="contacts page-section">
  <div class="container">
    <div class="contacts__top">
      <h3 class="contacts__title">Send Message </h3>
      <div class="contacts__description">
        <p>Send us a message and we will reply to you within 24 hours!</p>
      </div>
    </div>
    <div class="contacts__row">
      <div class="contacts__col">
        <div class="contacts-form block-form">

         <form action="{{ route('contact.send') }}" method="POST">
    @csrf
    <div class="field">
        <label>Your Login</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <small style="color:red;">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label>E-mail</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <small style="color:red;">{{ $message }}</small> @enderror
    </div>

    <div class="field">
        <label>Message</label>
        <textarea name="message" class="js-textarea" required>{{ old('message') }}</textarea>
        @error('message') <small style="color:red;">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn btn--primary btn--large">Send</button>

    @if(session('success'))
        <p style="color: green; margin-top: 10px;">{{ session('success') }}</p>
    @endif
</form>

        </div>
      </div>
      <div class="contacts__col">
        <ul class="social-links">

          </li>
        </ul>
      </div>
    </div>
  </div>
</section>


<script src="temp/custom/js/jquery.min.js"></script>



@include('home.footer')