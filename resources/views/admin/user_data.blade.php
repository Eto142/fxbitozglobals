@include('admin.header')
<div class="main-panel">
    <div class="content bg-dark">
        <div class="page-inner">
            @if(session('message'))
            <div class="alert alert-success mb-2">{{session('message')}}</div>
            @endif
            <div>
            </div>
            <div>
            </div> <!-- Beginning of  Dashboard Stats  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="p-3 card bg-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <h1 class="d-inline text-primary">{{$user->name}}</h1>
                                    <span></span>
                                    <div class="d-inline">
                                        <div class="float-right btn-group">
                                            <a class="btn btn-primary btn-sm" href="{{route('manage.users.page')}}"> <i
                                                    class="fa fa-arrow-left"></i> back</a> &nbsp;
                                            <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                data-toggle="dropdown" data-display="static" aria-haspopup="true"
                                                aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-lg-right">
                                                <a class="dropdown-item" href="">Login Activity</a>
                                                <a class="dropdown-item" href="#">Block</a>
                                                <a class="dropdown-item" href="">Turn off trade</a>

                                                <a href="#" data-toggle="modal" data-target="#topupModal"
                                                    class="dropdown-item">Credit/Debit</a>
                                                {{-- <a href="#" data-toggle="modal" data-target="#topupxModal"
                                                    class="dropdown-item">Fund / Wallet</a> --}}
                                                <a href="#" data-toggle="modal" data-target="#resetpswdModal"
                                                    class="dropdown-item">Reset Password</a>
                                                <a href="#" data-toggle="modal" data-target="#clearacctModal"
                                                    class="dropdown-item">Clear Account</a>
                                                <a href="#" data-toggle="modal" data-target="#TradingModal"
                                                    class="dropdown-item">Add Signal Strength</a>
                                                <a href="#" data-toggle="modal" data-target="#edituser"
                                                    class="dropdown-item">Edit</a>
                                                <a href="#" data-toggle="modal" data-target="#sendmailtooneuserModal"
                                                    class="dropdown-item">Send Email</a>
                                                <a href="#" data-toggle="modal" data-target="#switchuserModal"
                                                    class="dropdown-item text-success">Gain Access</a>
                                                <a href="#" data-toggle="modal" data-target="#deleteModal"
                                                    class="dropdown-item text-danger">Delete {{$user->name}}</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 mt-4 border rounded row text-light">
                                <div class="col-md-3">
                                    <h5 class="text-bold">Account Balance</h5>
                                    <p>${{number_format($balance_sum, 2, '.', ',')}}</p>
                                </div>
                                <div class="col-md-3">
                                    <h5>Total Profit</h5>
                                    <p>${{number_format($profit_sum, 2, '.', ',')}}</p>
                                </div>
                                <div class="col-md-3">
                                    <h5>Total Deposit</h5>
                                    <p>${{number_format($successful_deposits_sum, 2, '.', ',')}}</p>
                                </div>
                                <div class="col-md-3">
                                    <h5>User Account Status</h5>
                                    <span class="badge badge-success">Active</span>
                                </div>
                                <div class="col-md-3">
                                    <h5>Trades</h5>

                                    <a class="btn btn-sm btn-primary d-inline"
                                        href="{{ route('admin.user.trades', $user->id) }}">Add Trade</a>


                                </div>
                                
                                
                                <div class="col-md-3" style="margin-bottom: 20px;">
    <h5 style="color: #e2e8f0; font-weight: 600;">Account Status</h5>
    <p style="color: #cbd5e1; font-size: 15px;">{{$user->activation_status}}</p>

    <!-- Button trigger modal -->
    <button class="btn btn-sm"
        style="background-color: #14b8a6; color: #fff; border: none; border-radius: 8px;
               padding: 6px 12px; font-weight: 500; transition: all 0.3s ease;"
        data-toggle="modal" data-target="#updateStatusModal"
        onmouseover="this.style.backgroundColor='#0d9488'"
        onmouseout="this.style.backgroundColor='#14b8a6'">
        Update Account Status
    </button>
</div>

<div class="col-md-3" style="margin-bottom: 20px;">
    <h5 style="color: #e2e8f0; font-weight: 600;">Crypto Address</h5>
    <p style="color: #cbd5e1; font-size: 15px;">{{ $user->crypto_address ?? 'Not set' }}</p>

    <!-- Button trigger modal -->
    <button class="btn btn-sm"
        style="background-color: #8b5cf6; color: #fff; border: none; border-radius: 8px;
               padding: 6px 12px; font-weight: 500; transition: all 0.3s ease;"
        data-toggle="modal" data-target="#updateCryptoModal"
        onmouseover="this.style.backgroundColor='#7c3aed'"
        onmouseout="this.style.backgroundColor='#8b5cf6'">
        Update Crypto Address
    </button>
</div>




                                
                               
                                
                                <div class="col-md-3">
                                    <h5>KYC</h5>
                                    {{-- @if($kyc_status=="0")
                                    <span class="badge badge-danger">Not Verified Yet</span>
                                    @elseif($kyc_status=="1")
                                    <span class="badge badge-success">Verified</span>@endif --}}
                                </div>
                                <div class="col-md-3">
                                    <h5>Signal Strength</h5>
                                    <span class="badge badge-success">{{$user->signal_strength}}%</span>
                                </div> 
                                
                              <div class="col-md-3" style="margin-bottom: 20px;">
    <h5 style="color: #e2e8f0; font-weight: 600;">Transactions Status</h5>

    <!-- Status write-ups -->
    <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 8px;">
        <strong>Self Deposit:</strong> 
        <span class="badge {{ $user->can_deposit ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_deposit ? 'Unlocked' : 'Locked' }}
        </span>
    </p>
    <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 8px;">
        <strong>Self Withdraw:</strong> 
        <span class="badge {{ $user->can_withdraw ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_withdraw ? 'Unlocked' : 'Locked' }}
        </span>
    </p>
    <p style="color: #cbd5e1; font-size: 14px; margin-bottom: 12px;">
        <strong>Intra Transfer:</strong> 
        <span class="badge {{ $user->can_intra_transfer ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_intra_transfer ? 'Unlocked' : 'Locked' }}
        </span>
    </p>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-sm"
        style="background-color: #6c757d; color: #fff; border: none; border-radius: 8px;
               padding: 6px 12px; font-weight: 500; transition: all 0.3s ease;"
        data-toggle="modal" data-target="#transactionModal{{ $user->id }}"
        onmouseover="this.style.backgroundColor='#5a6268'"
        onmouseout="this.style.backgroundColor='#6c757d'">
        Manage Transactions
    </button>
</div>

    <!-- Plans Lock Status -->
    <div class="col-md-3" style="margin-bottom: 20px;">
        <h5 style="color: #e2e8f0; font-weight: 600;">Plans</h5>
        <span class="badge {{ $user->can_access_plans ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_access_plans ? 'Unlocked' : 'Locked' }}
        </span>
        <button type="button" class="btn btn-sm mt-2"
            style="background-color: #6366f1; color: #fff; border: none; border-radius: 8px;"
            data-toggle="modal" data-target="#plansLockModal{{ $user->id }}">
            Manage Plans Access
        </button>
    </div>

    <!-- Stock Markets Lock Status -->
    <div class="col-md-3" style="margin-bottom: 20px;">
        <h5 style="color: #e2e8f0; font-weight: 600;">Stock Markets</h5>
        <span class="badge {{ $user->can_access_stocks ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_access_stocks ? 'Unlocked' : 'Locked' }}
        </span>
        <button type="button" class="btn btn-sm mt-2"
            style="background-color: #f59e42; color: #fff; border: none; border-radius: 8px;"
            data-toggle="modal" data-target="#stocksLockModal{{ $user->id }}">
            Manage Stocks Access
        </button>
    </div>

    <!-- Trade Lock Status -->
    <div class="col-md-3" style="margin-bottom: 20px;">
        <h5 style="color: #e2e8f0; font-weight: 600;">Trade</h5>
        <span class="badge {{ $user->can_access_trade ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_access_trade ? 'Unlocked' : 'Locked' }}
        </span>
        <button type="button" class="btn btn-sm mt-2"
            style="background-color: #10b981; color: #fff; border: none; border-radius: 8px;"
            data-toggle="modal" data-target="#tradeLockModal{{ $user->id }}">
            Manage Trade Access
        </button>
    </div>

    <!-- Transaction History Lock Status -->
    <div class="col-md-3" style="margin-bottom: 20px;">
        <h5 style="color: #e2e8f0; font-weight: 600;">Transaction History</h5>
        <span class="badge {{ $user->can_access_transactions ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_access_transactions ? 'Unlocked' : 'Locked' }}
        </span>
        <button type="button" class="btn btn-sm mt-2"
            style="background-color: #ef4444; color: #fff; border: none; border-radius: 8px;"
            data-toggle="modal" data-target="#transactionsLockModal{{ $user->id }}">
            Manage Transactions History
        </button>
    </div>

    <!-- Settings Lock Status -->
    <div class="col-md-3" style="margin-bottom: 20px;">
        <h5 style="color: #e2e8f0; font-weight: 600;">Settings</h5>
        <span class="badge {{ $user->can_access_settings ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_access_settings ? 'Unlocked' : 'Locked' }}
        </span>
        <button type="button" class="btn btn-sm mt-2"
            style="background-color: #fbbf24; color: #fff; border: none; border-radius: 8px;"
            data-toggle="modal" data-target="#settingsLockModal{{ $user->id }}">
            Manage Settings Access
        </button>
    </div>

    <!-- Other Lock Status -->
    <div class="col-md-3" style="margin-bottom: 20px;">
        <h5 style="color: #e2e8f0; font-weight: 600;">Other</h5>
        <span class="badge {{ $user->can_access_other ? 'badge-success' : 'badge-danger' }}">
            {{ $user->can_access_other ? 'Unlocked' : 'Locked' }}
        </span>
        <button type="button" class="btn btn-sm mt-2"
            style="background-color: #636363; color: #fff; border: none; border-radius: 8px;"
            data-toggle="modal" data-target="#otherLockModal{{ $user->id }}">
            Manage Other Access
        </button>
    </div>

<!-- Modal -->
<div class="modal fade" id="transactionModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header border-bottom border-secondary">
        <h5 class="modal-title" id="transactionModalLabel{{ $user->id }}">
            <i class="fas fa-exchange-alt mr-2"></i> Transaction Controls
        </h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('admin.users.transactions.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">

          <!-- Self Deposit -->
          <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_deposit ? 'bg-success' : 'bg-danger' }}">
            <div class="col">
              <label class="mb-0 font-weight-medium">Self Deposit</label>
              <small class="d-block text-light">Allow user to fund their account</small>
            </div>
            <div class="col-auto">
              <span class="badge {{ $user->can_deposit ? 'badge-light' : 'badge-dark' }}">
                  {{ $user->can_deposit ? 'Unlocked' : 'Locked' }}
              </span>
              <div class="custom-control custom-switch mt-1">
                <input type="checkbox" class="custom-control-input" id="canDeposit{{ $user->id }}" name="can_deposit" value="1" @checked($user->can_deposit)>
                <label class="custom-control-label" for="canDeposit{{ $user->id }}"></label>
              </div>
            </div>
          </div>

          <!-- Self Withdraw -->
          <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_withdraw ? 'bg-success' : 'bg-danger' }}">
            <div class="col">
              <label class="mb-0 font-weight-medium">Self Withdraw</label>
              <small class="d-block text-light">Allow user to withdraw funds</small>
            </div>
            <div class="col-auto">
              <span class="badge {{ $user->can_withdraw ? 'badge-light' : 'badge-dark' }}">
                  {{ $user->can_withdraw ? 'Unlocked' : 'Locked' }}
              </span>
              <div class="custom-control custom-switch mt-1">
                <input type="checkbox" class="custom-control-input" id="canWithdraw{{ $user->id }}" name="can_withdraw" value="1" @checked($user->can_withdraw)>
                <label class="custom-control-label" for="canWithdraw{{ $user->id }}"></label>
              </div>
            </div>
          </div>

          <!-- Intra Transfer -->
          <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_intra_transfer ? 'bg-success' : 'bg-danger' }}">
            <div class="col">
              <label class="mb-0 font-weight-medium">Intra Transfer</label>
              <small class="d-block text-light">Allow internal transfers</small>
            </div>
            <div class="col-auto">
              <span class="badge {{ $user->can_intra_transfer ? 'badge-light' : 'badge-dark' }}">
                  {{ $user->can_intra_transfer ? 'Unlocked' : 'Locked' }}
              </span>
              <div class="custom-control custom-switch mt-1">
                <input type="checkbox" class="custom-control-input" id="canTransfer{{ $user->id }}" name="can_intra_transfer" value="1" @checked($user->can_intra_transfer)>
                <label class="custom-control-label" for="canTransfer{{ $user->id }}"></label>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer border-top border-secondary">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">
            <i class="fas fa-save mr-1"></i> Save Changes
          </button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- Plans Lock Modal -->
<div class="modal fade" id="plansLockModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="plansLockModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="plansLockModalLabel{{ $user->id }}">
                        <i class="fas fa-lock mr-2"></i> Plans Access Control
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.plans.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_access_plans ? 'bg-success' : 'bg-danger' }}">
                        <div class="col">
                            <label class="mb-0 font-weight-medium">Plans Access</label>
                            <small class="d-block text-light">Allow user to access plans</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge {{ $user->can_access_plans ? 'badge-light' : 'badge-dark' }}">
                                    {{ $user->can_access_plans ? 'Unlocked' : 'Locked' }}
                            </span>
                            <div class="custom-control custom-switch mt-1">
                                <input type="checkbox" class="custom-control-input" id="canAccessPlans{{ $user->id }}" name="can_access_plans" value="1" @checked($user->can_access_plans)>
                                <label class="custom-control-label" for="canAccessPlans{{ $user->id }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Stock Markets Lock Modal -->
<div class="modal fade" id="stocksLockModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="stocksLockModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="stocksLockModalLabel{{ $user->id }}">
                        <i class="fas fa-lock mr-2"></i> Stock Markets Access Control
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.stocks.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_access_stocks ? 'bg-success' : 'bg-danger' }}">
                        <div class="col">
                            <label class="mb-0 font-weight-medium">Stock Markets Access</label>
                            <small class="d-block text-light">Allow user to access stock markets</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge {{ $user->can_access_stocks ? 'badge-light' : 'badge-dark' }}">
                                    {{ $user->can_access_stocks ? 'Unlocked' : 'Locked' }}
                            </span>
                            <div class="custom-control custom-switch mt-1">
                                <input type="checkbox" class="custom-control-input" id="canAccessStocks{{ $user->id }}" name="can_access_stocks" value="1" @checked($user->can_access_stocks)>
                                <label class="custom-control-label" for="canAccessStocks{{ $user->id }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Trade Lock Modal -->
<div class="modal fade" id="tradeLockModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="tradeLockModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="tradeLockModalLabel{{ $user->id }}">
                        <i class="fas fa-lock mr-2"></i> Trade Access Control
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.trade.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_access_trade ? 'bg-success' : 'bg-danger' }}">
                        <div class="col">
                            <label class="mb-0 font-weight-medium">Trade Access</label>
                            <small class="d-block text-light">Allow user to access trade features</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge {{ $user->can_access_trade ? 'badge-light' : 'badge-dark' }}">
                                    {{ $user->can_access_trade ? 'Unlocked' : 'Locked' }}
                            </span>
                            <div class="custom-control custom-switch mt-1">
                                <input type="checkbox" class="custom-control-input" id="canAccessTrade{{ $user->id }}" name="can_access_trade" value="1" @checked($user->can_access_trade)>
                                <label class="custom-control-label" for="canAccessTrade{{ $user->id }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Transaction History Lock Modal -->
<div class="modal fade" id="transactionsLockModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="transactionsLockModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="transactionsLockModalLabel{{ $user->id }}">
                        <i class="fas fa-lock mr-2"></i> Transaction History Access Control
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.transactionsHistory.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_access_transactions ? 'bg-success' : 'bg-danger' }}">
                        <div class="col">
                            <label class="mb-0 font-weight-medium">Transaction History Access</label>
                            <small class="d-block text-light">Allow user to access transaction history</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge {{ $user->can_access_transactions ? 'badge-light' : 'badge-dark' }}">
                                    {{ $user->can_access_transactions ? 'Unlocked' : 'Locked' }}
                            </span>
                            <div class="custom-control custom-switch mt-1">
                                <input type="checkbox" class="custom-control-input" id="canAccessTransactions{{ $user->id }}" name="can_access_transactions" value="1" @checked($user->can_access_transactions)>
                                <label class="custom-control-label" for="canAccessTransactions{{ $user->id }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Settings Lock Modal -->
<div class="modal fade" id="settingsLockModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="settingsLockModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="settingsLockModalLabel{{ $user->id }}">
                        <i class="fas fa-lock mr-2"></i> Settings Access Control
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.settings.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_access_settings ? 'bg-success' : 'bg-danger' }}">
                        <div class="col">
                            <label class="mb-0 font-weight-medium">Settings Access</label>
                            <small class="d-block text-light">Allow user to access settings</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge {{ $user->can_access_settings ? 'badge-light' : 'badge-dark' }}">
                                    {{ $user->can_access_settings ? 'Unlocked' : 'Locked' }}
                            </span>
                            <div class="custom-control custom-switch mt-1">
                                <input type="checkbox" class="custom-control-input" id="canAccessSettings{{ $user->id }}" name="can_access_settings" value="1" @checked($user->can_access_settings)>
                                <label class="custom-control-label" for="canAccessSettings{{ $user->id }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Other Lock Modal -->
<div class="modal fade" id="otherLockModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="otherLockModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title" id="otherLockModalLabel{{ $user->id }}">
                        <i class="fas fa-lock mr-2"></i> Other Access Control
                </h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.other.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row align-items-center py-2 px-3 rounded mb-2 {{ $user->can_access_other ? 'bg-success' : 'bg-danger' }}">
                        <div class="col">
                            <label class="mb-0 font-weight-medium">Other Access</label>
                            <small class="d-block text-light">Allow user to access other features</small>
                        </div>
                        <div class="col-auto">
                            <span class="badge {{ $user->can_access_other ? 'badge-light' : 'badge-dark' }}">
                                    {{ $user->can_access_other ? 'Unlocked' : 'Locked' }}
                            </span>
                            <div class="custom-control custom-switch mt-1">
                                <input type="checkbox" class="custom-control-input" id="canAccessOther{{ $user->id }}" name="can_access_other" value="1" @checked($user->can_access_other)>
                                <label class="custom-control-label" for="canAccessOther{{ $user->id }}"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
                </div>
            </div>
<div class="row">
    <div class="col-md-12">
        <div class="card bg-dark text-white p-3 mb-4">
            <div class="card-body">
                <h5 class="mb-3">USER INFORMATION</h5>
                
                <div class="user-info mb-3">
                    <p><strong>Name:</strong> <span class="text-white">{{ ucwords($user->name) }}</span></p>
                    <hr class="border-secondary">
                    
                    <p><strong>Email:</strong> <span class="text-white">{{$user->email}}</span></p>
                    <hr class="border-secondary">
                    
                    <p><strong>Phone:</strong> <span class="text-white">{{$user->phone}}</span></p>
                    <hr class="border-secondary">
                    
                    <p><strong>Country:</strong> <span class="text-white">{{$user->country}}</span></p>
                    <hr class="border-secondary">
                    
                    <p><strong>Registered:</strong> <span class="text-white">{{ \Carbon\Carbon::parse($user->created_at)->format('D, M j, Y g:i A') }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <!-- Top Up Modal first -->
    
    
    
    <div id="topupModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title text-light">Credit/Debit {{$user->name}} account.</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body bg-dark">
                <form action="{{route('credit-debit')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="currency_symbol" value="{{$user->currency_symbol}}">

                    <!-- Amount -->
                    <div class="form-group">
                        <input class="form-control bg-dark text-light" placeholder="Enter amount" type="text" name="amount" required>
                    </div>

                    <!-- Select column -->
                    <div class="form-group">
                        <h5 class="text-light">Select where to Credit/Debit</h5>
                        <select id="typeSelect" class="form-control bg-dark text-light" name="type" required>
                            <option value="" selected disabled>Select Column</option>
                            <option value="Profit">Profit</option>
                            <option value="balance">Account Balance</option>
                            <option value="Deposit">Deposit</option>
                        </select>
                    </div>

                    <!-- Credit/Debit type -->
                    <div class="form-group">
                        <h5 class="text-light">Select credit to add, debit to subtract.</h5>
                        <select class="form-control bg-dark text-light" name="t_type" required>
                            <option value="">Select type</option>
                            <option value="Credit">Credit</option>
                            <option value="Debit">Debit</option>
                        </select>
                        <small><b>NOTE:</b> You cannot debit deposit</small>
                    </div>

                    <!-- Deposit details (hidden by default) -->
                    <div id="depositFields" style="display:none;">
                        <hr class="bg-light">

                        <div class="form-group">
                            <input type="text" class="form-control bg-dark text-light" name="description" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control bg-dark text-light" name="payer_name" placeholder="Payer Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control bg-dark text-light" name="sender_name" placeholder="Sender name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control bg-dark text-light" name="sender_account" placeholder="Sender account number">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control bg-dark text-light" name="date_time" placeholder="Date/Time">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control bg-dark text-success" name="dep_status"  placeholder="Enter status">
                        </div>

                        <!-- Deposit Email Alert Toggle (Improved UI) -->
                        <div class="form-group row align-items-center py-2 px-3 rounded mb-2 bg-info">
                            <div class="col d-flex align-items-center">
                                <label class="mb-0 font-weight-bold" for="depositEmailAlert{{ $user->id }}" style="font-size: 16px;">
                                    Deposit Email Alert
                                    <span tabindex="0" data-toggle="tooltip" title="If enabled, the user will receive an email notification when a deposit is credited.">
                                        <i class="fa fa-info-circle text-light ml-1"></i>
                                    </span>
                                </label>
                                <small class="d-block text-light ml-2" style="font-size: 13px;">Send email to user when deposit is credited</small>
                            </div>
                            <div class="col-auto">
                                <div class="custom-control custom-switch mt-1">
                                    <input type="checkbox" class="custom-control-input" id="depositEmailAlert{{ $user->id }}" name="deposit_email_alert" value="1" @checked($user->deposit_email_alert ?? false)>
                                    <label class="custom-control-label" for="depositEmailAlert{{ $user->id }}">
                                        <span id="depositEmailAlertText{{ $user->id }}">{{ ($user->deposit_email_alert ?? false) ? 'ON' : 'OFF' }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <script>
                        // Update ON/OFF text when toggled
                        document.addEventListener('DOMContentLoaded', function() {
                            var alertToggle = document.getElementById('depositEmailAlert{{ $user->id }}');
                            var alertText = document.getElementById('depositEmailAlertText{{ $user->id }}');
                            if(alertToggle && alertText) {
                                alertToggle.addEventListener('change', function() {
                                    alertText.textContent = this.checked ? 'ON' : 'OFF';
                                });
                            }
                            // Enable Bootstrap tooltip
                            $(function () {
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        });
                        </script>
                    </div>

                    <!-- Submit -->
                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-light btn-block" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
document.getElementById('typeSelect').addEventListener('change', function() {
    const depositFields = document.getElementById('depositFields');
    if (this.value === 'Deposit') {
        depositFields.style.display = 'block';
    } else {
        depositFields.style.display = 'none';
    }
});
</script>

    <!--<div id="topupModal" class="modal fade" role="dialog">-->
    <!--    <div class="modal-dialog">-->
            <!-- Modal content-->
    <!--        <div class="modal-content">-->
    <!--            <div class="modal-header bg-dark">-->
    <!--                <h4 class="modal-title text-light">Credit/Debit {{$user->name}}-->
    <!--                    account.</strong></h4>-->
    <!--                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>-->
    <!--            </div>-->
    <!--            <div class="modal-body bg-dark">-->
    <!--                <form action="{{route('credit-debit')}}" method="POST" enctype="multipart/form-data">-->
    <!--                    {{ csrf_field()}}-->
    <!--                    <div class="form-group">-->
    <!--                        <input type="hidden" class="form-control" name="user_id" value="{{$user->id}}">-->
    <!--                    </div>-->
    <!--                    <div class="form-group">-->
    <!--                        <input class="form-control bg-dark text-light" placeholder="Enter amount" type="text"-->
    <!--                            name="amount" required>-->
    <!--                    </div>-->
    <!--                    <div class="form-group">-->
    <!--                        <h5 class="text-light">Select where to Credit/Debit</h5>-->
    <!--                        <select class="form-control bg-dark text-light" name="type" required>-->
    <!--                            <option value="" selected disabled>Select Column</option>-->
    <!--                            <option value="Profit">Profit</option>-->
    <!--                            {{-- <option value="Ref_Bonus">Ref_Bonus</option> --}}-->
    <!--                            <option value="balance">Account Balance</option>-->
    <!--                            <option value="Deposit">Deposit</option>-->
    <!--                        </select>-->
    <!--                    </div>-->
    <!--                    <div class="form-group">-->
    <!--                        <h5 class="text-light">Select credit to add, debit to subtract.</h5>-->
    <!--                        <select class="form-control bg-dark text-light" name="t_type" required>-->
    <!--                            <option value="">Select type</option>-->
    <!--                            <option value="Credit">Credit</option>-->
    <!--                            <option value="Debit">Debit</option>-->
    <!--                        </select>-->
    <!--                        <small> <b>NOTE:</b> You cannot debit deposit</small>-->
    <!--                    </div>-->
    <!--                    <div class="form-group">-->
    <!--                        <input type="submit" class="btn btn-light" value="Submit">-->
    <!--                    </div>-->
    <!--                </form>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- /deposit for a plan Modal -->




    <!-- Top Up Modal -->
    <div id="topupxModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">Fund/Debit {{$user->name}} WALLET.</strong></h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <form action="" method="POST" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        <div class="form-group">
                            <input class="form-control bg-dark text-light" placeholder="Enter amount" type="text"
                                name="amount" required>
                        </div>
                        <div class="form-group">
                            <h5 class="text-light">Select Wallet to Credit/Debit</h5>
                            <select class="form-control bg-dark text-light" name="type" required>
                                <option value="" selected disabled>Select Wallet</option>
                                <option value="Bitcoin">Bitcoin</option>
                                <option value="Ethereum">Ethereum</option>
                                <option value="LTC">LTC</option>
                                <option value="BNB">BNB</option>
                                <option value="Doge">Doge</option>
                                <option value="USDT">USDT</option>
                                <option value="Dash">Dash</option>
                                <option value="Tron">Tron</option>
                                <option value="XRP">XRP</option>
                                <option value="EOS">EOS</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h5 class="text-light">Select credit to add, debit to subtract.</h5>
                            <select class="form-control bg-dark text-light" name="t_type" required>
                                <option value="">Select type</option>
                                <option value="Credit">Credit</option>
                                <option value="Debit">Debit</option>
                            </select>
                            <small> <b>NOTE:</b> You cannot debit deposit</small>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_id" value="151">
                            <input type="submit" class="btn btn-light" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /deposit for a plan Modal -->












    <!-- send a single user email Modal-->
    <div id="sendmailtooneuserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">Send Email</h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <p class="text-light">This message will be sent to {{$user->name}}</p>
                    <form style="padding:3px;" role="form" method="post" action="{{ route('admin.send.mail')}}">

                        @csrf
                        <input type="hidden" name="email" value="{{$user->email}}">
                        <div class=" form-group">
                            <input type="text" name="subject" class="form-control bg-dark text-light"
                                placeholder="Subject" required>
                        </div>
                        <div class=" form-group">
                            <textarea placeholder="Type your message here" class="form-control bg-dark text-light"
                                name="message" row="8" placeholder="Type your message here" required></textarea>
                        </div>
                        <div class=" form-group">

                            <input type="submit" class="btn btn-light" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Trading History Modal -->

    <div id="TradingModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">Add Signal strength for {{$user->name}} </h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <form role="form" method="post" action="{{ route('admin.add_signal_strength') }}">
                        @csrf

                        <div class="form-group">
                            <h5 class="text-light">Signal Strength</h5>
                            <input type="number" name="signal_strength" class="form-control bg-dark text-light" min="0"
                                max="100" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-light" value="Add Signal Strength">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /send a single user email Modal -->

    <!-- Edit user Modal -->
    <div id="edituser" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">Edit {{$user->name}} details</h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <form role="form" method="post" action="{{ route('admin.updateUser', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="text-light">First Name</label>
                            <input class="form-control bg-dark text-light" id="input1" value="{{$user->name}}"
                                type="text" name="username" required>
                        </div>
                        <div class="form-group">
                            <label class="text-light">Last Name</label>
                            <input class="form-control bg-dark text-light" value="{{$user->last_name}}" type="text"
                                name="name" required>
                        </div>
                        <div class="form-group">
                            <label class="text-light">Email</label>
                            <input class="form-control bg-dark text-light" value="{{$user->email}}" type="text"
                                name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="text-light">Phone Number</label>
                            <input class="form-control bg-dark text-light" value="{{$user->phone}}" type="text"
                                name="phone" required>
                        </div>
                        <div class="form-group">
                            <label class="text-light">Country</label>
                            <input class="form-control bg-dark text-light" value="{{$user->country}}" type="text"
                                name="country">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-light" value="Update">
                        </div>
                    </form>
                </div>
                <script>
                    $('#input1').on('keypress', function(e) {
                    return e.which !== 32; // Disallow spaces in username
                });
                </script>
            </div>
        </div>
    </div>
    <!-- /Edit user Modal -->


    <!-- Reset user password Modal -->
    <div id="resetpswdModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">Reset Password</strong></h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <p class="text-light">Are you sure you want to reset password for {{$user->name}} to <span
                            class="text-primary font-weight-bolder">user01236</span></p>
                    <a class="btn btn-light" href="{{ route('reset.password', $user->id) }}">Reset Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Reset user password Modal -->

    <!-- Switch useraccount Modal -->
    <div id="switchuserModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">You are about to login as {{$user->name}}.</strong></h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <a class="btn btn-success" href="{{ route('users.impersonate', $user->id) }}">Proceed</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Switch user account Modal -->

    <!-- Clear account Modal -->
    <div id="clearacctModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title text-light">Clear Account</strong></h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark">
                    <p class="text-light">You are clearing account for {{$user->name}} to $0.00</p>
                    <a class="btn btn-light" href="{{route('clear.account',$user->id)}}">Proceed</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Clear account Modal -->

    <!-- Delete user Modal -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-dark">

                    <h4 class="modal-title text-light">Delete User</strong></h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-dark p-3">
                    <p class="text-light">Are you sure you want to delete {{$user->name}}
                        Account? Everything
                        associated
                        with this account will be loss.</p>
                    <a class="btn btn-danger" href="{{ route('delete.user', $user->id) }}">Yes i'm sure</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete user Modal -->
    
    
    
    <!-- Update Account Status Modal -->
<div id="updateStatusModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title text-light">Update Account Status</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{ route('admin.user.updateActivationStatus', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body bg-dark">
                    <div class="form-group">
                        <label for="status" class="text-light">Enter New Status</label>
                        <input type="text" name="activation_status" id="status" class="form-control" 
                               placeholder="e.g., Active, Inactive, Suspended"
                               value="{{ $user->activation_status ?? '' }}" required>
                    </div>
                </div>

                <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-light">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Crypto Address Modal -->
<div id="updateCryptoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title text-light">Update Crypto Address</h4>
                <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{ route('admin.user.updateCryptoAddress', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body bg-dark">
                    <div class="form-group">
                        <label for="crypto_address" class="text-light">Enter New Crypto Address</label>
                        <input type="text" name="crypto_address" id="crypto_address" class="form-control"
                               placeholder="e.g., 0x3e5f4b...."
                               value="{{ $user->crypto_address ?? '' }}" required>
                    </div>
                </div>

                <div class="modal-footer bg-dark">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-light">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>





    @include('admin.footer')