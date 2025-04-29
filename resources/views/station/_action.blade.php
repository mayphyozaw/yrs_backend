<x-detail-button href="{{ route('station.show', $station->id) }}">
    <i class="fas fa-info-circle"></i>
</x-detail-button>



<x-edit-button href="{{ route('station.edit', $station->id) }}">
    <i class="fas fa-edit"></i>
</x-edit-button>

<x-delete-button href="#" class="delete-button" data-url="{{ route('station.destroy',$station->id) }}">
    <i class="fas fa-trash-alt"></i>
</x-delete-button>