@include('dashboard.header')

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            {{-- Success and Error Messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">
                            <a class="btn btn-primary" href="{{ route('user.deposits.history') }}">
                                Deposit History
                            </a>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Make a Deposit</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.store.deposit') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                {{-- Deposit Amount --}}
                                <div class="mt-4">
                                    <h4 class="text-dark">
                                        <span style="color:red">*</span> You are about to make a deposit of
                                        <strong>${{ number_format($amount, 2) }}</strong>.
                                    </h4>
                                </div>

                                @if($payment->type == 'crypto')
                                {{-- CRYPTO DETAILS --}}
                                <div class="mt-3">
                                    <h5 class="text-dark">Crypto Asset: {{ $payment->name }}</h5>
                                    <p>Copy the wallet address below and complete your payment.</p>
                                </div>

                                {{-- Wallet Address --}}
                                <div class="mb-3">
                                    <label for="wallet_address" class="form-label">Wallet Address</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="wallet_address"
                                            value="{{ $payment->wallet_address }}" readonly>
                                        <button class="btn btn-secondary" type="button"
                                            onclick="copyToClipboard()">Copy</button>
                                    </div>
                                </div>

                                {{-- QR Code --}}
                                <div class="mb-3 text-center">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $payment->wallet_address }}"
                                        style="width:200px;">
                                    <br>
                                    <small class="text-dark">
                                        <strong><span style="color:red">*</span></strong> You can scan QR code when
                                        making deposit through supported apps.
                                    </small>
                                </div>

                                @elseif($payment->type == 'bank')
                                {{-- BANK DETAILS --}}
                                <div class="mt-3">
                                    <h5 class="text-dark">Bank Deposit</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Bank Name:</strong>FXBITOZ GLOBAL BANK</li>
                                        <li class="list-group-item"><strong>Account Name:</strong> {{
                                            Auth::user()->name }}</li>
                                        <li class="list-group-item"><strong>Account Number:</strong> {{
                                            Auth::user()->account_number }}</li>
                                        @if($payment->code)
                                        <li class="list-group-item"><strong>Reference:</strong> {{
                                            Auth::user()->username}}</li>
                                        @endif
                                    </ul>
                                    <small class="text-muted d-block mt-2">
                                        Please include your username as reference when sending funds.
                                    </small>
                                </div>
                                
                                <div class="col-md-6">
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description">
    </div>
</div>
                                
                                 @elseif($payment->type == 'currency')
<!--                               <div class="col-md-6">-->
<!--    <div class="mb-3">-->
<!--        <label for="bank_name" class="form-label">username</label>-->
<!--        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter bank name" >-->
<!--    </div>-->
<!--</div>-->

<!--<div class="col-md-6">-->
<!--    <div class="mb-3">-->
<!--        <label for="account_name" class="form-label">Account Name</label>-->
<!--        <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter account name" >-->
<!--    </div>-->
<!--</div>-->

<!--<div class="col-md-6">-->
<!--    <div class="mb-3">-->
<!--        <label for="account_number" class="form-label">Account Number</label>-->
<!--        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Enter account number">-->
<!--    </div>-->
<!--</div>-->


         <div class="mt-3">
                                    <h5 class="text-dark">Bank Deposit</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Bank Name:</strong>FXBITOZ GLOBAL BANK</li>
                                        <li class="list-group-item"><strong>Account Name:</strong> {{
                                            Auth::user()->name }}</li>
                                        <li class="list-group-item"><strong>Account Number:</strong> {{
                                            Auth::user()->account_number }}</li>
                                        @if($payment->code)
                                        <li class="list-group-item"><strong>Reference:</strong> {{
                                            Auth::user()->username}}</li>
                                        @endif
                                    </ul>
                                    <!--<small class="text-muted d-block mt-2">-->
                                    <!--    Please include your username as reference when sending funds.-->
                                    <!--</small>-->
                                </div>

<div class="col-md-6">
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description">
    </div>
</div>

                                
                                
                                @endif

                                {{-- Upload Proof --}}
                                <div class="mb-3 mt-4">
                                    <label for="proof" class="form-label">Upload Payment Proof</label>
                                    <input type="file" class="form-control" id="proof" name="proof" required>
                                    <small class="form-text text-muted">Supported formats: jpg, jpeg, png, pdf. Max
                                        size: 20MB.</small>
                                </div>

                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="type" value="{{ $payment->type }}">
                                <input type="hidden" name="name" value="{{ $payment->name }}">

                                {{-- Submit --}}
                                <button type="submit" class="btn btn-primary">Submit Deposit</button>
                                <a href="{{ route('user.deposit') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const walletInput = document.getElementById('wallet_address');
        walletInput.select();
        walletInput.setSelectionRange(0, 99999); 
        document.execCommand('copy');
        alert('Wallet address copied to clipboard!');
    }
</script>

@include('dashboard.footer')