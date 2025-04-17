<x-edit-button href="{{ route('admin-user.edit', $admin_user->id) }}">
    <i class="fas fa-edit"></i>
</x-edit-button>

<x-delete-button href="#" class="delete-button" data-delete-url="{{ route('admin-user.destroy',$admin_user->id) }}">
    <i class="fas fa-trash-alt"></i>
</x-delete-button>