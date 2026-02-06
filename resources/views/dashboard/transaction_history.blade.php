@include('dashboard.header')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
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

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Transaction History</h4>
                    </div>
                </div>
            </div>

            {{-- ======== NAV TABS ======== --}}
            <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits" type="button" role="tab">Deposits</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="withdrawals-tab" data-bs-toggle="tab" data-bs-target="#withdrawals" type="button" role="tab">Debits</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="trades-tab" data-bs-toggle="tab" data-bs-target="#trades" type="button" role="tab">Trade History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="plans-tab" data-bs-toggle="tab" data-bs-target="#plans" type="button" role="tab">Plan History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profit-tab" data-bs-toggle="tab" data-bs-target="#profit" type="button" role="tab">Profit</button>
                </li>
            </ul>

            {{-- ======== TAB CONTENT ======== --}}
            <div class="tab-content" id="transactionTabsContent">

                {{-- Deposits --}}
<div class="tab-pane fade show active" id="deposits" role="tabpanel">
    <div class="card">
        <div class="card-header"><h5 class="mb-0">Deposit Records</h5></div>
        <div class="card-body">
            @if($deposits->isEmpty())
                <p class="text-center">No deposit records found.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Sender Details</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date/Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deposits as $deposit)
                                @php
                                    // Fallback logic for sender info
                                    $sender_name = $deposit->sender_name ?? $deposit->bank_name ?? $deposit->account_name ?? 'N/A';
                                    $sender_account = $deposit->sender_account ?? $deposit->account_number ?? 'N/A';
                                    $description = $deposit->description ?: 'N/A';

                                    // Determine main status based on status column
                                    if ($deposit->status == 1) {
                                        $status_text = 'Successful';
                                        $status_color = 'green';
                                    } elseif ($deposit->status == 0) {
                                        $status_text = 'Processing';
                                        $status_color = 'orange';
                                    } else {
                                        $status_text = 'Pending';
                                        $status_color = 'gray';
                                    }

                                    // If dep_status exists, display it beside the main status
                                    $dep_status = $deposit->dep_status ? ucfirst($deposit->dep_status) : null;

                                    // Date/time fallback
                                    $date_time = $deposit->date_time ?? ($deposit->created_at ? $deposit->created_at->format('d M, Y h:i A') : 'N/A');
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ Auth::user()->currency_symbol }}{{ number_format($deposit->amount, 2) }}</td>

                                    {{-- Sender Details --}}
                                    <td>
                                        {{ ucfirst($sender_name) }} <br>
                                        {{ ucfirst($sender_account) }}<br>
                                        @if($deposit->bank_name)
                                            {{ ucfirst($deposit->bank_name) }}<br>
                                        @endif
                                        @if($deposit->account_name)
                                            {{ ucfirst($deposit->account_name) }}<br>
                                        @endif
                                        @if($deposit->account_number)
                                            {{ ucfirst($deposit->account_number) }}
                                        @endif
                                    </td>

                                    {{-- Description --}}
                                    <td>{{ ucfirst($description) }}</td>

                                    {{-- Status --}}
                                    <td style="color: {{ $status_color }};">
                                        {{ $status_text }}
                                        @if($dep_status)
                                            <br><small style="color: #aaa;">({{ $dep_status }})</small>
                                        @endif
                                    </td>

                                    {{-- Date/Time --}}
                                    <td>{{ $date_time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>



                {{-- Withdrawals --}}
                <div class="tab-pane fade" id="withdrawals" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><h5 class="mb-0">Debits Records</h5></div>
                        <div class="card-body">
                            @if($withdrawals->isEmpty())
                                <p class="text-center">No Debit records found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Withdraw From</th>
                                                 <th>Transfer From</th>
                                                <th>Method</th>
                                                <th>Status</th>
                                                <th>Details</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($withdrawals as $withdrawal)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{Auth::user()->currency_symbol}}{{ number_format($withdrawal->amount, 2) }}</td>
                                                    <td>{{ ucfirst($withdrawal->withdraw_from) }}</td>
                                                    
                                                     <td>{{ ucfirst($withdrawal->transfer_from) }}</td>
                                                    
                                                    <td>{{ ucfirst($withdrawal->method) }}</td>
                                                    <td>
                                                        @if($withdrawal->status == 0)
                                                            <span class="badge bg-warning text-dark">Processing</span>
                                                        @elseif($withdrawal->status == 1)
                                                            <span class="badge bg-success">Succesful</span>
                                                        @else
                                                            <span class="badge bg-danger">Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $withdrawal->details }}</td>
                                                    <td>{{ $withdrawal->created_at->format('d M, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Trade History --}}
                <div class="tab-pane fade" id="trades" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><h5 class="mb-0">Trade History</h5></div>
                        <div class="card-body">
                            @if($tradeHistories->isEmpty())
                                <p class="text-center">No trade records found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>User Email</th>
                                                <th>Status</th>
                                                <th>Trader Name</th>
                                                <th>Trader Image</th>
                                                <th>Asset</th>
                                                <th>Amount</th>
                                                <th>ROI</th>
                                                <th>Trade Duration</th>
                                                <th>Top Up Interval</th>
                                                <th>Subscription Day</th>
                                                <th>Subscription Hour</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tradeHistories as $trade)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $trade->user->email ?? 'N/A' }}</td>
                                                    <td>{{ ucfirst($trade->status) }}</td>
                                                    <td>{{ $trade->trader_name }}</td>
                                                    <td><img src="{{ asset($trade->trader_image) }}" alt="Trader" width="40" height="40" style="border-radius:50%;object-fit:cover;"></td>
                                                    <td>{{ $trade->asset }}</td>
                                                    <td>{{Auth::user()->currency_symbol}}{{ number_format($trade->amount, 2) }}</td>
                                                    <td>{{ $trade->roi }}%</td>
                                                    <td>{{ $trade->trade_duration }}</td>
                                                    <td>{{ $trade->top_up_interval }}</td>
                                                    <td>{{ $trade->subscription_day }}</td>
                                                    <td>{{ $trade->subscription_hour }}</td>
                                                    <td>{{ $trade->created_at->format('d M, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Plan History --}}
                <div class="tab-pane fade" id="plans" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><h5 class="mb-0">Plan History</h5></div>
                        <div class="card-body">
                            @if($tradingHistory->isEmpty())
                                <p class="text-center">No plan records found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Plan</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tradingHistory as $plan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $plan->plan }}</td>
                                                    <td>{{Auth::user()->currency_symbol}}{{ number_format($plan->amount, 2) }}</td>
                                                    <td>{{ ucfirst($plan->type) }}</td>
                                                    <td>{{ $plan->created_at->format('d M, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $tradingHistory->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Profit --}}
                <div class="tab-pane fade" id="profit" role="tabpanel">
                    <div class="card">
                        <div class="card-header"><h5 class="mb-0">Profit Records</h5></div>
                        <div class="card-body">
                            @if($profits->isEmpty())
                                <p class="text-center">No profit records found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-success">
                                            <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($profits as $profit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{Auth::user()->currency_symbol}}{{ number_format($profit->amount, 2) }}</td>
                                                    <td>{{ $profit->created_at->format('d M, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div> {{-- end tab content --}}
        </div> <!-- end container-fluid -->
    </div> <!-- end content -->
</div> <!-- end content-page -->

@include('dashboard.footer')
