@extends('admin.layout')

@section('title', 'Order Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Order Management</h1>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search by customer name, email, or package...">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                        <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Package</th>
                                <th>Event Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                <tr>
                                    <td>{{ $orders->firstItem() + $index }}</td>
                                    <td>
                                        <strong class="text-primary">#{{ $order->order_id }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->user->name ?? 'Unknown' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->user->email ?? 'No email' }}</small>
                                            @if($order->user->username)
                                                <br>
                                                <small class="text-muted">@{{ $order->user->username }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->catalogue->package_name ?? 'Package Deleted' }}</strong>
                                            @if($order->catalogue)
                                                <br>
                                                <small class="text-muted">Base Price: Rp {{ number_format($order->catalogue->price, 0, ',', '.') }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->event_date)
                                            <strong>{{ \Carbon\Carbon::parse($order->event_date)->format('d M Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($order->event_date)->format('l') }}</small>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                                        @if($order->catalogue && $order->total_price != $order->catalogue->price)
                                            <br>
                                            <small class="text-info">Custom pricing</small>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-info">Confirmed</span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-success">Completed</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <strong>{{ $order->created_at->format('d M Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('orders.show', $order->order_id) }}" 
                                               class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($order->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-success" 
                                                        onclick="updateOrderStatus({{ $order->order_id }}, 'confirmed')" title="Confirm Order">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if(in_array($order->status, ['pending', 'confirmed']))
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="updateOrderStatus({{ $order->order_id }}, 'cancelled')" title="Cancel Order">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            @if($order->status == 'confirmed')
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        onclick="updateOrderStatus({{ $order->order_id }}, 'completed')" title="Mark as Completed">
                                                    <i class="fas fa-flag-checkered"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No orders found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <p class="text-muted mb-0">
                                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} 
                                of {{ $orders->total() }} results
                            </p>
                        </div>
                        <div>
                            {{ $orders->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="statusModalText">Are you sure you want to update this order status?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="statusForm" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="statusInput" name="status">
                    <button type="submit" class="btn btn-primary" id="statusSubmitBtn">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .btn-group .btn {
        margin-right: 2px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn-group .btn {
            margin-right: 0;
            margin-bottom: 2px;
        }
    }
    
    .badge {
        font-size: 0.75em;
    }
</style>
@endsection

@section('scripts')
<script>
    function updateOrderStatus(orderId, status) {
        const statusForm = document.getElementById('statusForm');
        const statusInput = document.getElementById('statusInput');
        const statusModalText = document.getElementById('statusModalText');
        const statusSubmitBtn = document.getElementById('statusSubmitBtn');
        
        statusForm.action = `/orders/${orderId}`;
        statusInput.value = status;
        
        let statusText = '';
        let btnClass = 'btn-primary';
        
        switch(status) {
            case 'confirmed':
                statusText = 'confirm this order';
                btnClass = 'btn-success';
                break;
            case 'completed':
                statusText = 'mark this order as completed';
                btnClass = 'btn-primary';
                break;
            case 'cancelled':
                statusText = 'cancel this order';
                btnClass = 'btn-danger';
                break;
        }
        
        statusModalText.textContent = `Are you sure you want to ${statusText}?`;
        statusSubmitBtn.className = `btn ${btnClass}`;
        statusSubmitBtn.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        
        const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
        statusModal.show();
    }
</script>
@endsection