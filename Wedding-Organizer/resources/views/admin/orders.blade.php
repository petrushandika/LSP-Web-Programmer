@extends('layouts.admin')

@section('title', 'Order Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Management</h3>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div class="d-flex gap-3 flex-wrap">
                            <div>
                                <label for="search" class="form-label">Search Orders</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Search by customer name, email..." style="min-width: 250px;">
                            </div>
                            <div>
                                <label for="package_filter" class="form-label">Package</label>
                                <select class="form-select" id="package_filter" name="package" style="min-width: 180px;">
                                    <option value="">All Packages</option>
                                    @foreach($catalogues as $catalogue)
                                        <option value="{{ $catalogue->id }}">
                                            {{ $catalogue->package_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status_filter" class="form-label">Status</label>
                                <select class="form-select" id="status_filter" name="status" style="min-width: 150px;">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-outline-secondary me-2" onclick="resetFilters()">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
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
                                <!-- Table content will be loaded via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Orders pagination">
                            <ul class="pagination">
                                <!-- Pagination will be loaded via JavaScript -->
                            </ul>
                        </nav>
                    </div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Order Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-receipt me-2"></i>Order Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <strong>Order ID:</strong>
                                        <p id="viewOrderId" class="mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <strong>Status:</strong>
                                        <p id="viewOrderStatus" class="mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <strong>Order Date:</strong>
                                        <p id="viewOrderDate" class="mb-2"></p>
                                    </div>
                                    <div class="col-6">
                                        <strong>Event Date:</strong>
                                        <p id="viewEventDate" class="mb-2"></p>
                                    </div>
                                    <div class="col-12">
                                        <strong>Total Price:</strong>
                                        <p id="viewTotalPrice" class="mb-0 fs-5 text-success"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-user me-2"></i>Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <strong>Name:</strong>
                                        <p id="viewCustomerName" class="mb-2"></p>
                                    </div>
                                    <div class="col-12">
                                        <strong>Email:</strong>
                                        <p id="viewCustomerEmail" class="mb-2"></p>
                                    </div>
                                    <div class="col-12">
                                        <strong>Phone:</strong>
                                        <p id="viewCustomerPhone" class="mb-2"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Information -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="fas fa-box me-2"></i>Package Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div id="viewPackageImageContainer">
                                            <img id="viewPackageImage" src="" alt="Package image" class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                        <div id="viewNoPackageImage" class="text-center py-4" style="display: none;">
                                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">No image</p>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <h5 id="viewPackageName" class="text-primary mb-3"></h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <strong>Base Price:</strong>
                                                <p id="viewPackagePrice" class="mb-2"></p>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Package Status:</strong>
                                                <p id="viewPackageStatus" class="mb-2"></p>
                                            </div>
                                            <div class="col-12">
                                                <strong>Description:</strong>
                                                <p id="viewPackageDescription" class="mb-0"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <div id="orderActionButtons">
                    <!-- Action buttons will be dynamically added based on order status -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Confirmation Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusUpdateModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i id="statusUpdateIcon" class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                    <h5 id="statusUpdateTitle">Confirm Status Update</h5>
                    <p class="text-muted">Are you sure you want to update the status of order <strong id="statusUpdateOrderId"></strong> to <strong id="statusUpdateNewStatus"></strong>?</p>
                    <div id="statusUpdateWarning" class="alert alert-warning mt-3" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="statusUpdateWarningText"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmStatusUpdateBtn">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="display: none;"></span>
                    <span>Update Status</span>
                </button>
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
    let currentOrders = [];
    let currentPage = 1;
    let totalPages = 1;
    let currentOrderId = null;
    let currentNewStatus = null;

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        loadOrders();
        
        // Search functionality
        document.getElementById('search').addEventListener('input', debounce(function() {
            currentPage = 1;
            loadOrders();
        }, 300));
        
        // Filter functionality
        document.getElementById('package_filter').addEventListener('change', function() {
            currentPage = 1;
            loadOrders();
        });
        
        document.getElementById('status_filter').addEventListener('change', function() {
            currentPage = 1;
            loadOrders();
        });
        
        // Status update confirmation
        document.getElementById('confirmStatusUpdateBtn').addEventListener('click', confirmStatusUpdate);
    });

    // Debounce function for search
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Load orders from API
    async function loadOrders(page = 1) {
        try {
            showLoading(true);
            
            const searchTerm = document.getElementById('search').value;
            const packageFilter = document.getElementById('package_filter').value;
            const statusFilter = document.getElementById('status_filter').value;
            
            const params = new URLSearchParams({
                page: page,
                per_page: 10
            });
            
            if (searchTerm) params.append('search', searchTerm);
            if (packageFilter) params.append('package', packageFilter);
            if (statusFilter) params.append('status', statusFilter);
            
            const response = await fetch(`/admin/api/orders?${params}`);
            const data = await response.json();
            
            if (data.success) {
                currentOrders = data.data.data;
                currentPage = data.data.current_page;
                totalPages = data.data.last_page;
                
                renderOrdersTable();
                renderPagination();
            } else {
                showError('Failed to load orders: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error loading orders:', error);
            showError('Failed to load orders. Please try again.');
        } finally {
            showLoading(false);
        }
    }

    // Render orders table
    function renderOrdersTable() {
        const tableBody = document.querySelector('tbody');
        
        if (currentOrders.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Orders Found</h5>
                            <p class="text-muted mb-0">No orders match your current search criteria.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        tableBody.innerHTML = currentOrders.map(order => {
            const statusBadge = getStatusBadge(order.status);
            const packageImage = order.catalogue && order.catalogue.image 
                ? `/storage/${order.catalogue.image}` 
                : null;
            
            return `
                <tr>
                    <td><strong>#${order.id}</strong></td>
                    <td>
                        <div class="d-flex flex-column">
                            <strong>${order.user ? order.user.name : 'N/A'}</strong>
                            <small class="text-muted">${order.user ? order.user.email : 'N/A'}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            ${packageImage ? `
                                <img src="${packageImage}" alt="Package" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                            ` : `
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            `}
                            <div>
                                <strong>${order.catalogue ? order.catalogue.package_name : 'N/A'}</strong>
                                <br><small class="text-muted">Rp ${order.catalogue ? formatPrice(order.catalogue.price) : '0'}</small>
                            </div>
                        </div>
                    </td>
                    <td>${formatDate(order.event_date)}</td>
                    <td><strong class="text-success">Rp ${formatPrice(order.total_price)}</strong></td>
                    <td>${statusBadge}</td>
                    <td><small class="text-muted">${formatDateTime(order.created_at)}</small></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewOrder(${order.id})" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${getActionButtons(order)}
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Get status badge HTML
    function getStatusBadge(status) {
        const badges = {
            'pending': '<span class="badge bg-warning text-dark">Pending</span>',
            'confirmed': '<span class="badge bg-info">Confirmed</span>',
            'completed': '<span class="badge bg-success">Completed</span>',
            'cancelled': '<span class="badge bg-danger">Cancelled</span>'
        };
        return badges[status] || `<span class="badge bg-secondary">${status}</span>`;
    }

    // Get action buttons based on order status
    function getActionButtons(order) {
        let buttons = '';
        
        switch(order.status) {
            case 'pending':
                buttons += `
                    <button type="button" class="btn btn-sm btn-success" onclick="updateOrderStatus(${order.id}, 'confirmed')" title="Confirm Order">
                        <i class="fas fa-check"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="updateOrderStatus(${order.id}, 'cancelled')" title="Cancel Order">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                break;
            case 'confirmed':
                buttons += `
                    <button type="button" class="btn btn-sm btn-primary" onclick="updateOrderStatus(${order.id}, 'completed')" title="Complete Order">
                        <i class="fas fa-check-double"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="updateOrderStatus(${order.id}, 'cancelled')" title="Cancel Order">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                break;
        }
        
        return buttons;
    }

    // View order details
    async function viewOrder(orderId) {
        try {
            const response = await fetch(`/admin/api/orders/${orderId}`);
            const data = await response.json();
            
            if (data.success) {
                const order = data.data;
                
                // Populate order information
                document.getElementById('viewOrderId').textContent = `#${order.id}`;
                document.getElementById('viewOrderStatus').innerHTML = getStatusBadge(order.status);
                document.getElementById('viewOrderDate').textContent = formatDateTime(order.created_at);
                document.getElementById('viewEventDate').textContent = formatDate(order.event_date);
                document.getElementById('viewTotalPrice').textContent = `Rp ${formatPrice(order.total_price)}`;
                
                // Populate customer information
                document.getElementById('viewCustomerName').textContent = order.user ? order.user.name : 'N/A';
                document.getElementById('viewCustomerEmail').textContent = order.user ? order.user.email : 'N/A';
                document.getElementById('viewCustomerPhone').textContent = order.user ? (order.user.phone || 'N/A') : 'N/A';
                
                // Populate package information
                if (order.catalogue) {
                    document.getElementById('viewPackageName').textContent = order.catalogue.package_name;
                    document.getElementById('viewPackagePrice').textContent = `Rp ${formatPrice(order.catalogue.price)}`;
                    document.getElementById('viewPackageStatus').innerHTML = `<span class="badge bg-${order.catalogue.status === 'active' ? 'success' : 'secondary'}">${order.catalogue.status}</span>`;
                    document.getElementById('viewPackageDescription').textContent = order.catalogue.description || 'No description available';
                    
                    // Handle package image
                    if (order.catalogue.image) {
                        document.getElementById('viewPackageImage').src = `/storage/${order.catalogue.image}`;
                        document.getElementById('viewPackageImageContainer').style.display = 'block';
                        document.getElementById('viewNoPackageImage').style.display = 'none';
                    } else {
                        document.getElementById('viewPackageImageContainer').style.display = 'none';
                        document.getElementById('viewNoPackageImage').style.display = 'block';
                    }
                } else {
                    document.getElementById('viewPackageName').textContent = 'Package not found';
                    document.getElementById('viewPackagePrice').textContent = 'N/A';
                    document.getElementById('viewPackageStatus').innerHTML = '<span class="badge bg-secondary">N/A</span>';
                    document.getElementById('viewPackageDescription').textContent = 'Package information not available';
                    document.getElementById('viewPackageImageContainer').style.display = 'none';
                    document.getElementById('viewNoPackageImage').style.display = 'block';
                }
                
                // Add action buttons
                const actionButtonsContainer = document.getElementById('orderActionButtons');
                actionButtonsContainer.innerHTML = getModalActionButtons(order);
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
                modal.show();
            } else {
                showError('Failed to load order details: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error loading order details:', error);
            showError('Failed to load order details. Please try again.');
        }
    }

    // Get modal action buttons
    function getModalActionButtons(order) {
        let buttons = '';
        
        switch(order.status) {
            case 'pending':
                buttons = `
                    <button type="button" class="btn btn-success me-2" onclick="updateOrderStatus(${order.id}, 'confirmed')">
                        <i class="fas fa-check me-1"></i>Confirm Order
                    </button>
                    <button type="button" class="btn btn-danger" onclick="updateOrderStatus(${order.id}, 'cancelled')">
                        <i class="fas fa-times me-1"></i>Cancel Order
                    </button>
                `;
                break;
            case 'confirmed':
                buttons = `
                    <button type="button" class="btn btn-primary me-2" onclick="updateOrderStatus(${order.id}, 'completed')">
                        <i class="fas fa-check-double me-1"></i>Complete Order
                    </button>
                    <button type="button" class="btn btn-danger" onclick="updateOrderStatus(${order.id}, 'cancelled')">
                        <i class="fas fa-times me-1"></i>Cancel Order
                    </button>
                `;
                break;
        }
        
        return buttons;
    }

    // Update order status
    function updateOrderStatus(orderId, newStatus) {
        currentOrderId = orderId;
        currentNewStatus = newStatus;
        
        // Update modal content
        document.getElementById('statusUpdateOrderId').textContent = `#${orderId}`;
        document.getElementById('statusUpdateNewStatus').textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
        
        // Set appropriate icon and warning based on status
        const icon = document.getElementById('statusUpdateIcon');
        const warning = document.getElementById('statusUpdateWarning');
        const warningText = document.getElementById('statusUpdateWarningText');
        
        if (newStatus === 'cancelled') {
            icon.className = 'fas fa-exclamation-triangle fa-3x text-danger mb-3';
            warning.style.display = 'block';
            warningText.textContent = 'This action cannot be undone. The order will be permanently cancelled.';
        } else if (newStatus === 'completed') {
            icon.className = 'fas fa-check-circle fa-3x text-success mb-3';
            warning.style.display = 'block';
            warningText.textContent = 'Make sure all services have been delivered before marking as completed.';
        } else {
            icon.className = 'fas fa-question-circle fa-3x text-warning mb-3';
            warning.style.display = 'none';
        }
        
        // Hide view modal if open
        const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewOrderModal'));
        if (viewModal) {
            viewModal.hide();
        }
        
        // Show status update modal
        const modal = new bootstrap.Modal(document.getElementById('statusUpdateModal'));
        modal.show();
    }

    // Confirm status update
    async function confirmStatusUpdate() {
        if (!currentOrderId || !currentNewStatus) return;
        
        const button = document.getElementById('confirmStatusUpdateBtn');
        const spinner = button.querySelector('.spinner-border');
        const text = button.querySelector('span:last-child');
        
        try {
            // Show loading state
            button.disabled = true;
            spinner.style.display = 'inline-block';
            text.textContent = 'Updating...';
            
            const response = await fetch(`/admin/api/orders/${currentOrderId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: currentNewStatus
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Hide modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('statusUpdateModal'));
                modal.hide();
                
                // Show success message
                showSuccess(`Order status updated to ${currentNewStatus} successfully!`);
                
                // Reload orders
                loadOrders(currentPage);
                
                // Reset current values
                currentOrderId = null;
                currentNewStatus = null;
            } else {
                showError('Failed to update order status: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error updating order status:', error);
            showError('Failed to update order status. Please try again.');
        } finally {
            // Reset button state
            button.disabled = false;
            spinner.style.display = 'none';
            text.textContent = 'Update Status';
        }
    }

    // Render pagination
    function renderPagination() {
        const paginationContainer = document.querySelector('.pagination');
        
        if (totalPages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }
        
        let paginationHTML = '';
        
        // Previous button
        paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="${currentPage > 1 ? `changePage(${currentPage - 1})` : 'return false;'}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        `;
        
        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);
        
        if (startPage > 1) {
            paginationHTML += '<li class="page-item"><a class="page-link" href="#" onclick="changePage(1)"><strong>1</strong></a></li>';
            if (startPage > 2) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        }
        
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})"><strong>${i}</strong></a>
                </li>
            `;
        }
        
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${totalPages})"><strong>${totalPages}</strong></a></li>`;
        }
        
        // Next button
        paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="${currentPage < totalPages ? `changePage(${currentPage + 1})` : 'return false;'}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        `;
        
        paginationContainer.innerHTML = paginationHTML;
    }

    // Change page
    function changePage(page) {
        if (page >= 1 && page <= totalPages && page !== currentPage) {
            loadOrders(page);
        }
    }

    // Reset filters
    function resetFilters() {
        document.getElementById('search').value = '';
        document.getElementById('package_filter').value = '';
        document.getElementById('status_filter').value = '';
        currentPage = 1;
        loadOrders();
    }

    // Utility functions
    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    function formatDateTime(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function showLoading(show) {
        const tableBody = document.querySelector('tbody');
        if (show) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading orders...</p>
                    </td>
                </tr>
            `;
        }
    }

    function showError(message) {
        // Create and show error toast/alert
        const alertHTML = `
            <div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHTML);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert-danger');
            if (alert) alert.remove();
        }, 5000);
    }

    function showSuccess(message) {
        // Create and show success toast/alert
        const alertHTML = `
            <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;" role="alert">
                <i class="fas fa-check-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHTML);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) alert.remove();
        }, 3000);
    }
</script>
@endsection