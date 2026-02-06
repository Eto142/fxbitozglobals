@include('admin.header')
<div class="main-panel">
	<div class="content bg-dark">
		<div class="page-inner">
			<div class="mt-2 mb-4">
				<h1 class="title1 text-light">Manage clients withdrawals/transfers</h1>
			</div>
			<div>
			</div>
			<div>
			</div>
			<div class="mb-5 row">
				<div class="col card p-3 shadow bg-dark">
					<div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table">
						<span style="margin:3px;">
<!--							<table id="ShipTable" class="table table-hover text-light">-->
<!--								<thead>-->
<!--									<tr>-->
<!--										<th>ID</th>-->
<!--										<th>Client name</th>-->
<!--										<th>Amount requested</th>-->
<!--										<th>Payment Method</th>-->
<!--										<th>details</th>-->
<!--										<th>Status</th>-->
<!--										<th>Date created</th>-->
<!--									</tr>-->
<!--								</thead>-->
<!--								<tbody>-->
<!--									@foreach($withdrawals as $with) <tr>-->
<!--										<th scope="row">{{$with->id}}</th>-->
<!--										<td>{{$with->name}}</td>-->
<!--										<td>${{number_format($with->amount, 2, '.', ',')}}</td>-->
<!--										<td>{{$with->method}}</td>-->
<!--										<td>{{$with->details}}</td>-->

<!--<td>-->
<!--    @if($with->status === '0')-->
<!--        <span style="background: #ff5b5b; color: #fff; padding: 3px 8px; border-radius: 4px;">Processing</span>-->
<!--    @elseif($with->status === '2')-->
<!--        <span style="background: #fbc02d; color: #000; padding: 3px 8px; border-radius: 4px;">Pending</span>-->
<!--    @elseif($with->status === '1')-->
<!--        <span style="background: #28a745; color: #fff; padding: 3px 8px; border-radius: 4px;">Successful</span>-->
<!--    @endif-->

<!--    <button class="custom-btn btn-primary" onclick="openModal({{ $with->id }})">Update</button>-->

    <!-- Modal -->
<!--    <div id="modal{{ $with->id }}" class="custom-modal">-->
<!--        <div class="custom-modal-content">-->
<!--            <span class="close-modal" onclick="closeModal({{ $with->id }})">&times;</span>-->
<!--            <h3 style="font-size: 16px; margin-bottom: 10px;">Update Withdrawal</h3>-->

<!--            <form action="{{ route('withdrawals.approve', $with->id) }}" method="POST">-->
<!--                @csrf-->
<!--                @method('PATCH')-->
<!--                <label for="status{{ $with->id }}">Select Status</label>-->
<!--                <select id="status{{ $with->id }}" name="status" required -->
<!--                        style="width:100%; padding:6px; border-radius:5px; border:1px solid #ccc; margin-top:5px;">-->
<!--                    <option value="0" {{ $with->status === '0' ? 'selected' : '' }}>Processing</option>-->
<!--                    <option value="2" {{ $with->status === '2' ? 'selected' : '' }}>Pending</option>-->
<!--                    <option value="1" {{ $with->status === '1' ? 'selected' : '' }}>Successful</option>-->
<!--                </select>-->

<!--                <div style="margin-top:15px; text-align:right;">-->
<!--                    <button type="button" class="custom-btn btn-secondary" onclick="closeModal({{ $with->id }})">Close</button>-->
<!--                    <button type="submit" class="custom-btn btn-primary">Save</button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</td>-->


<!--										<td>{{ \Carbon\Carbon::parse($with->created_at)->format('D, M j, Y g:i A') }}-->
<!--										</td>-->
<!--										{{-- <td>-->
<!--											<a href="{{ url('admin/view-withdrawal/'.$with->user_id.'/'.$with->id) }}"-->
<!--												class="m-1 btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>-->
<!--										</td> --}}-->
<!--										@endforeach-->
<!--									</tr>-->

<!--								</tbody>-->
<!--							</table>-->

<table id="ShipTable" class="table table-hover text-light">
    <thead>
        <tr>
            <th>ID</th>
            <th>Client name</th>
            <th>Amount requested</th>
            <th>Transaction Type</th>
            <th>Source</th>
            <th>Details</th>
            <th>Status</th>
            <th>Date created</th>
        </tr>
    </thead>
    <tbody>
        @foreach($withdrawals as $with)
        <tr>
            <th scope="row">{{ $with->id }}</th>

            <td>{{ $with->name }}</td>

            <td>${{ number_format($with->amount, 2, '.', ',') }}</td>

            {{-- Transaction Type --}}
            <td>
                @if(!is_null($with->transfer_from))
                    <span style="background:#2196f3; color:#fff; padding:3px 8px; border-radius:4px;">
                        Transfer
                    </span>
                    <br>
                     <p>{{ $with->receiver_email }}</p> 
                    
                @else
                    <span style="background:#9c27b0; color:#fff; padding:3px 8px; border-radius:4px;">
                        Withdrawal
                    </span>
                @endif
            </td>

            {{-- Source --}}
            <td>
                {{ $with->transfer_from ?? $with->withdraw_from }}
            </td>

            {{-- Details --}}
            <td style="white-space:pre-line;">
                {{ $with->details }}
            </td>

            {{-- Status --}}
            <td>
                @if($with->status == 0)
                    <span style="background:#ff5b5b; color:#fff; padding:3px 8px; border-radius:4px;">
                        Processing
                    </span>
                @elseif($with->status == 2)
                    <span style="background:#fbc02d; color:#000; padding:3px 8px; border-radius:4px;">
                        Pending
                    </span>
                @elseif($with->status == 1)
                    <span style="background:#28a745; color:#fff; padding:3px 8px; border-radius:4px;">
                        Successful
                    </span>
                @endif

                <button class="custom-btn btn-primary" onclick="openModal({{ $with->id }})">
                    Update
                </button>

                {{-- Modal --}}
                <div id="modal{{ $with->id }}" class="custom-modal">
                    <div class="custom-modal-content">
                        <span class="close-modal" onclick="closeModal({{ $with->id }})">&times;</span>

                        <h3 style="font-size:16px; margin-bottom:10px;">
                            Update Transaction
                        </h3>

                        <form action="{{ route('withdrawals.approve', $with->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <label for="status{{ $with->id }}">Select Status</label>

                            <select id="status{{ $with->id }}" name="status" required
                                style="width:100%; padding:6px; border-radius:5px; border:1px solid #ccc; margin-top:5px;">
                                <option value="0" {{ $with->status == 0 ? 'selected' : '' }}>Processing</option>
                                <option value="2" {{ $with->status == 2 ? 'selected' : '' }}>Pending</option>
                                <option value="1" {{ $with->status == 1 ? 'selected' : '' }}>Successful</option>
                            </select>

                            <div style="margin-top:15px; text-align:right;">
                                <button type="button" class="custom-btn btn-secondary"
                                    onclick="closeModal({{ $with->id }})">
                                    Close
                                </button>

                                <button type="submit" class="custom-btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </td>

            {{-- Date --}}
            <td>
                {{ \Carbon\Carbon::parse($with->created_at)->format('D, M j, Y g:i A') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	                                        <style>
/* Modal background overlay */
.custom-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.6);
}

/* Modal content box */
.custom-modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 12px;
    width: 300px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    text-align: left;
    animation: fadeIn 0.3s ease-in-out;
}

/* Close button */
.close-modal {
    color: #333;
    float: right;
    font-size: 20px;
    cursor: pointer;
}

.close-modal:hover {
    color: #e74c3c;
}

/* Buttons */
.custom-btn {
    padding: 6px 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn-primary {
    background-color: blue;
    color: #fff;
}

.btn-secondary {
    background-color: #ccc;
    color: #000;
}

/* Animations */
@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}
</style>
	
	
	
	<script>
function openModal(id) {
    document.getElementById('modal' + id).style.display = 'block';
}
function closeModal(id) {
    document.getElementById('modal' + id).style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.custom-modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
}
</script>
	@include('admin.footer')