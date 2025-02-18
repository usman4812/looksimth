@foreach ($menuItems as $item)
    <tr id="item-{{ $item->id }}">
        <td>
            <img src="{{ asset('storage/public/web_assets/media/meals/' . $item->meal->uuid . '/' . $item->meal->image) }}"
                width="50" class="img-thumbnail" alt="{{ $item->meal->title }}">
        </td>
        <td>{{ $item->meal->title }}</td>
        <td>{{ $item->meal->mealType->title }}</td>
        <td>{{ $item->meal->vendorDetails->name }}</td>
        <td>${{ $item->meal->price }}</td>
        <td>{{ $item->meal->is_featured ? 'Yes' : 'No' }}</td>
        <td>{{ $item->meal->is_autoselectable == 1 ? 'Yes' : 'No' }}</td>
        <td>
            <button class="btn btn-sm btn-danger remove-item" data-uuid="{{ $item->uuid }}">Remove</button>
        </td>
    </tr>
@endforeach
