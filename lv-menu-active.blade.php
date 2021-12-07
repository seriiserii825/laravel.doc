<a class="btn {{ request()->is('admin/pc') || request()->is('admin/pc/create') || request()->is('admin/pc/*/edit') ? 'btn--success' : '' }}" href="{{ route('product.index') }}">Products</a>
