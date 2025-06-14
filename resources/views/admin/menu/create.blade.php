@extends('layouts.theme.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Tabel Menu -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Label</th>
                        <th>Route</th>
                        <th>Icon</th>
                        <th>Parent</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menu->label }}</td>
                            <td>{{ $menu->route ?? '-' }}</td>
                            <td>{{ $menu->icon ?? '-' }}</td>
                            <td>{{ $menu->parent->label ?? '-' }}</td>
                            <td>{{ $menu->order }}</td>
                            <td>
                                <!-- Edit -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#menuModal"
                                    data-id="{{ $menu->id }}" data-label="{{ $menu->label }}"
                                    data-route="{{ $menu->route }}" data-icon="{{ $menu->icon }}"
                                    data-parent_id="{{ $menu->parent_id }}" data-order="{{ $menu->order }}">
                                    Edit
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this menu?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No menus found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('menus.store') }}" method="POST" id="menuForm">
                    @csrf
                    <input type="hidden" name="id" id="menu-id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalLabel">Add/Edit Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="menu-label" class="form-label">Label</label>
                            <input type="text" name="label" id="menu-label" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="menu-route" class="form-label">Route</label>
                            <input type="text" name="route" id="menu-route" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="menu-icon" class="form-label">Icon</label>
                            <input type="text" name="icon" id="menu-icon" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="menu-parent-id" class="form-label">Parent Menu</label>
                            <select name="parent_id" id="menu-parent-id" class="form-control">
                                <option value="">-- None (Main Menu) --</option>
                                @foreach ($menus as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="menu-order" class="form-label">Order</label>
                            <input type="number" name="order" id="menu-order" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
