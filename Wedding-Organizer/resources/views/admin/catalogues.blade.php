@extends('admin.layout')

@section('title', 'Catalogue Management')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">Catalogue Management</h1>
    </div>
</div>

<!-- Search, Filter and Add Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <!-- Search and Filter Section -->
                    <div class="flex-grow-1">
                        <form method="GET" action="{{ route('admin.catalogues') }}" class="row g-3" id="catalogueSearchForm">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Search by package name or description...">
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="Y" {{ request('status') == 'Y' ? 'selected' : '' }}>Published</option>
                                    <option value="N" {{ request('status') == 'N' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.catalogues') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Add Catalogue Button -->
                    <div class="flex-shrink-0">
                        <button type="button" class="btn" style="background-color: #ff69b4; border-color: #ff69b4; color: white;" onclick="openAddCatalogueModal()">
                            <i class="fas fa-plus me-1"></i>Add Catalogue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Catalogues Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Package Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($catalogues as $index => $catalogue)
                                <tr>
                                    <td>{{ $catalogues->firstItem() + $index }}</td>
                                    <td>
                                        @if($catalogue->image_url)
                                            <img src="{{ $catalogue->image_url }}" alt="{{ $catalogue->package_name }}" 
                                                 class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 4px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $catalogue->package_name }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $catalogue->catalogue_id }}</small>
                                    </td>
                                    <td>
                                        <div class="description-cell">
                                            {{ Str::limit($catalogue->description, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp {{ number_format($catalogue->price, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        @if($catalogue->status_publish == 'Y')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $catalogue->user->name ?? 'Unknown' }}
                                        <br>
                                        <small class="text-muted">{{ $catalogue->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    onclick="viewCatalogue({{ $catalogue->catalogue_id }})" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    onclick="editCatalogue({{ $catalogue->catalogue_id }})" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteCatalogue({{ $catalogue->catalogue_id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                            <h5 class="text-muted mb-2">No Catalogues Found</h5>
                                            <p class="text-muted mb-3">Start by adding your first wedding package catalogue</p>
                                            <button type="button" class="btn btn-primary" onclick="openAddCatalogueModal()">
                                                <i class="fas fa-plus me-2"></i>Add First Catalogue
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($catalogues->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <div class="pagination-info">
                            <span class="text-muted">
                                Showing <strong>{{ $catalogues->firstItem() }}</strong> to <strong>{{ $catalogues->lastItem() }}</strong> 
                                of <strong>{{ $catalogues->total() }}</strong> catalogues
                            </span>
                        </div>
                        <div class="pagination-wrapper">
                            {{ $catalogues->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Catalogue Modal -->
<div class="modal fade" id="catalogueModal" tabindex="-1" aria-labelledby="catalogueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="catalogueModalLabel">Add New Catalogue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="catalogueForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="package_name" class="form-label">Package Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="package_name" name="package_name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (IDR) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" min="0" step="1000" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="status_publish" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status_publish" name="status_publish" required>
                                <option value="">Select Status</option>
                                <option value="Y">Published</option>
                                <option value="N">Draft</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label">Package Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="form-text">Max file size: 2MB. Formats: JPG, PNG, GIF</div>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-12" id="currentImagePreview" style="display: none;">
                            <label class="form-label">Current Image</label>
                            <div>
                                <img id="currentImage" src="" alt="Current image" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="display: none;"></span>
                        <span id="submitBtnText">Save Catalogue</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Catalogue Modal -->
<div class="modal fade" id="viewCatalogueModal" tabindex="-1" aria-labelledby="viewCatalogueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCatalogueModalLabel">Catalogue Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-12">
                                <h4 id="viewPackageName" class="text-primary mb-2"></h4>
                                <p class="text-muted mb-3" id="viewCatalogueId"></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Price:</strong>
                                <p id="viewPrice" class="text-success fs-5 mb-0"></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                <p id="viewStatus" class="mb-0"></p>
                            </div>
                            <div class="col-12">
                                <strong>Description:</strong>
                                <p id="viewDescription" class="mb-0"></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created By:</strong>
                                <p id="viewCreatedBy" class="mb-0"></p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created Date:</strong>
                                <p id="viewCreatedDate" class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="viewImageContainer">
                            <strong>Package Image:</strong>
                            <div class="mt-2">
                                <img id="viewImage" src="" alt="Package image" class="img-fluid rounded" style="max-height: 300px;">
                            </div>
                        </div>
                        <div id="viewNoImage" class="text-center py-4" style="display: none;">
                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No image available</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="editCatalogueFromView()">Edit Catalogue</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Are you sure?</h5>
                    <p class="text-muted">You are about to delete the catalogue <strong id="deletePackageName"></strong>. This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="display: none;"></span>
                    <span>Yes, Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .description-cell {
        max-width: 200px;
        word-wrap: break-word;
    }
    
    .img-thumbnail {
        border: 1px solid #dee2e6;
    }
    
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
        
        .description-cell {
            max-width: 150px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    let currentCatalogueId = null;
    let isEditMode = false;

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Page is now server-side rendered, no need to load data via JavaScript
    });




    // Open add catalogue modal
    function openAddCatalogueModal() {
        isEditMode = false;
        currentCatalogueId = null;
        
        // Reset form
        document.getElementById('catalogueForm').reset();
        document.getElementById('catalogueModalLabel').textContent = 'Add New Catalogue';
        document.getElementById('submitBtnText').textContent = 'Save Catalogue';
        document.getElementById('currentImagePreview').style.display = 'none';
        
        // Clear validation states
        clearValidationStates();
        
        const modal = new bootstrap.Modal(document.getElementById('catalogueModal'));
        modal.show();
    }

    // View catalogue details
    function viewCatalogue(catalogueId) {
        fetch(`/admin/api/catalogues/${catalogueId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const catalogue = data.data;
                    
                    document.getElementById('viewPackageName').textContent = catalogue.package_name;
                    document.getElementById('viewCatalogueId').textContent = `ID: ${catalogue.id}`;
                    document.getElementById('viewPrice').textContent = `Rp ${parseInt(catalogue.price).toLocaleString('id-ID')}`;
                    document.getElementById('viewStatus').innerHTML = `<span class="badge ${catalogue.status_publish === 'Y' ? 'bg-success' : 'bg-secondary'}">${catalogue.status_publish === 'Y' ? 'Published' : 'Draft'}</span>`;
                    document.getElementById('viewDescription').textContent = catalogue.description;
                    document.getElementById('viewCreatedBy').textContent = catalogue.user ? catalogue.user.name : 'Unknown';
                    document.getElementById('viewCreatedDate').textContent = new Date(catalogue.created_at).toLocaleDateString('id-ID');
                    
                    // Handle image display
                    if (catalogue.image) {
                        document.getElementById('viewImage').src = `/storage/${catalogue.image}`;
                        document.getElementById('viewImageContainer').style.display = 'block';
                        document.getElementById('viewNoImage').style.display = 'none';
                    } else {
                        document.getElementById('viewImageContainer').style.display = 'none';
                        document.getElementById('viewNoImage').style.display = 'block';
                    }
                    
                    currentCatalogueId = catalogueId;
                    const modal = new bootstrap.Modal(document.getElementById('viewCatalogueModal'));
                    modal.show();
                } else {
                    showAlert('Error loading catalogue details: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Failed to load catalogue details', 'danger');
            });
    }

    // Edit catalogue
    function editCatalogue(catalogueId) {
        fetch(`/admin/api/catalogues/${catalogueId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const catalogue = data.data;
                    
                    isEditMode = true;
                    currentCatalogueId = catalogueId;
                    
                    // Populate form
                    document.getElementById('package_name').value = catalogue.package_name;
                    document.getElementById('description').value = catalogue.description;
                    document.getElementById('price').value = catalogue.price;
                    document.getElementById('status_publish').value = catalogue.status_publish;
                    
                    // Show current image if exists
                    if (catalogue.image) {
                        document.getElementById('currentImage').src = `/storage/${catalogue.image}`;
                        document.getElementById('currentImagePreview').style.display = 'block';
                    } else {
                        document.getElementById('currentImagePreview').style.display = 'none';
                    }
                    
                    // Update modal title and button
                    document.getElementById('catalogueModalLabel').textContent = 'Edit Catalogue';
                    document.getElementById('submitBtnText').textContent = 'Update Catalogue';
                    
                    // Clear validation states
                    clearValidationStates();
                    
                    const modal = new bootstrap.Modal(document.getElementById('catalogueModal'));
                    modal.show();
                } else {
                    showAlert('Error loading catalogue details: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Failed to load catalogue details', 'danger');
            });
    }

    // Edit catalogue from view modal
    function editCatalogueFromView() {
        const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewCatalogueModal'));
        viewModal.hide();
        
        setTimeout(() => {
            editCatalogue(currentCatalogueId);
        }, 300);
    }

    // Handle form submission
    document.getElementById('catalogueForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        const btnText = document.getElementById('submitBtnText');
        
        // Show loading state
        submitBtn.disabled = true;
        spinner.style.display = 'inline-block';
        btnText.textContent = isEditMode ? 'Updating...' : 'Saving...';
        
        const formData = new FormData(this);
        
        const url = isEditMode ? `/admin/api/catalogues/${currentCatalogueId}` : '/admin/api/catalogues';
        const method = isEditMode ? 'PUT' : 'POST';
        
        // For PUT requests, we need to handle FormData differently
        let requestOptions = {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        };
        
        if (isEditMode) {
            // Convert FormData to regular object for PUT request
            const data = {};
            for (let [key, value] of formData.entries()) {
                if (key === 'image' && value.size === 0) {
                    continue; // Skip empty file input
                }
                data[key] = value;
            }
            
            if (data.image && data.image instanceof File) {
                requestOptions.body = formData;
            } else {
                requestOptions.headers['Content-Type'] = 'application/json';
                requestOptions.body = JSON.stringify(data);
            }
        } else {
            requestOptions.body = formData;
        }
        
        fetch(url, requestOptions)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(isEditMode ? 'Catalogue updated successfully!' : 'Catalogue created successfully!', 'success');
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('catalogueModal'));
                    modal.hide();
                    
                    loadCatalogues();
                } else {
                    if (data.errors) {
                        displayValidationErrors(data.errors);
                    } else {
                        showAlert('Error: ' + data.message, 'danger');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Failed to save catalogue', 'danger');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                spinner.style.display = 'none';
                btnText.textContent = isEditMode ? 'Update Catalogue' : 'Save Catalogue';
            });
    });

    // Confirm delete
    function confirmDelete(catalogueId, packageName) {
        currentCatalogueId = catalogueId;
        document.getElementById('deletePackageName').textContent = packageName;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Handle delete confirmation
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        const btn = this;
        const spinner = btn.querySelector('.spinner-border');
        
        // Show loading state
        btn.disabled = true;
        spinner.style.display = 'inline-block';
        
        fetch(`/admin/api/catalogues/${currentCatalogueId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('Catalogue deleted successfully!', 'success');
                
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                modal.hide();
                
                loadCatalogues();
            } else {
                showAlert('Error deleting catalogue: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Failed to delete catalogue', 'danger');
        })
        .finally(() => {
            // Reset button state
            btn.disabled = false;
            spinner.style.display = 'none';
        });
    });

    // Search functionality
    document.getElementById('search').addEventListener('input', debounce(function() {
        document.getElementById('catalogueSearchForm').submit();
    }, 500));

    // Filter functionality
    document.getElementById('status').addEventListener('change', function() {
        document.getElementById('catalogueSearchForm').submit();
    });

    // Utility functions
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

    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) {
            // Create alert container if it doesn't exist
            const container = document.createElement('div');
            container.id = 'alertContainer';
            container.className = 'position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }
        
        const alertId = 'alert-' + Date.now();
        const alertHTML = `
            <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        document.getElementById('alertContainer').insertAdjacentHTML('beforeend', alertHTML);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            const alertElement = document.getElementById(alertId);
            if (alertElement) {
                const alert = new bootstrap.Alert(alertElement);
                alert.close();
            }
        }, 5000);
    }

    function displayValidationErrors(errors) {
        // Clear previous errors
        clearValidationStates();
        
        Object.keys(errors).forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errors[field][0];
                }
            }
        });
    }

    function clearValidationStates() {
        const inputs = document.querySelectorAll('#catalogueForm .form-control, #catalogueForm .form-select');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            }
        });
    }
</script>
@endsection