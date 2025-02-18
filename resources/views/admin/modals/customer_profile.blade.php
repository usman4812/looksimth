@if ($customerProfiles->isEmpty())
    <tr>
        <td colspan="5" class="text-center">No Profiles Added.</td>
    </tr>
@else
    @foreach ($customerProfiles as $customerProfile)
        <tr>
            <td>{{ $customerProfile->name }}</td>
            <td>{{ $customerProfile->email }}</td>
            <td>{{ $customerProfile->ehMealCustomerGroup->name }}</td>
            <td>
                @if ($customerProfile->active == 1)
                    <span class="badge badge-primary">Active</span>
                @else
                    <span class="badge badge-danger">In-active</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.customers.schedule', ['uuid' => $customerProfile->uuid]) }}"
                    class="btn main-success-color btn-active-color-success btn-sm px-4 me-2 wrap-all-style"><i
                        class="fa-solid fa-eye"></i>View</a>
                <a href="{{ route('admin.customers.delete', ['uuid' => $customerProfile->uuid]) }}"
                    data-uuid="{{ $customerProfile->uuid }}"
                    class="btn delete-btn main-warning-color btn-active-color-danger btn-sm px-4 me-5 wrap-all-style">Delete</a>
            </td>
        </tr>
    @endforeach
@endif
