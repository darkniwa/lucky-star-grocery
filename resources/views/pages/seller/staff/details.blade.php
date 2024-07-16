<div class="row">
    <div class="col-md-4 d-flex align-items-center justify-content-center">
        <img src="{{ $staff->picture ?: 'https://static.vecteezy.com/system/resources/previews/021/548/095/original/default-profile-picture-avatar-user-avatar-icon-person-icon-head-icon-profile-picture-icons-default-anonymous-user-male-and-female-businessman-photo-placeholder-social-network-avatar-portrait-free-vector.jpg' }}" alt="Staff Picture" class="img-fluid rounded default-picture">
    </div>
    <div class="col-md-8">
        <h3>{{ $staff->first_name }} {{ $staff->last_name }}</h3>
        <div class="mb-3">
            <strong>Email:</strong>
            <p>{{ $staff->user->email ?: 'N/A' }}</p>
        </div>
        <div class="mb-3">
            <strong>Mobile:</strong>
            <p>{{ $staff->user->mobile ?: 'N/A' }}</p>
        </div>
        <div class="mb-3">
            <strong>Birthday:</strong>
            <p>{{ $staff->birthday ?: 'N/A' }}</p>
        </div>
        <div class="mb-3">
            <strong>Gender:</strong>
            <p>{{ $staff->gender ?: 'N/A' }}</p>
        </div>
        <div class="mb-3">
            <strong>Employment Status:</strong>
            <p>{{ $staff->employment_status ?: 'N/A' }}</p>
        </div>
    </div>
</div>
<hr>
<h4>Activity Logs:</h4>
<ul class="list-group">
    @forelse($staff->user->activityLogs as $log)
        @php
            $properties = $log->properties;
            $timestamp = $log->created_at->format('F j, Y - h:i A');
        @endphp
        <li class="list-group-item bg-light">
            <strong>{{ $timestamp }}</strong>
        </li>
        <li class="list-group-item">
            @if (isset($properties['attributes']))
                @foreach($properties['attributes'] as $attribute => $change)
                    @php
                        // Replace underscores with spaces and capitalize the first letter
                        $friendlyAttributeName = ucwords(str_replace('_', ' ', $attribute));
                    @endphp
                    <code>{{ $friendlyAttributeName }}</code> changed from <code>{{ $change['old'] }}</code> to <code>{{ $change['new'] }}</code>
                    @if(!$loop->last)
                        <br>
                    @endif
                @endforeach
            @else
                {{ $log->description }}
            @endif
        </li>
    @empty
        <li class="list-group-item">
            No activity logs.
        </li>
    @endforelse
</ul>










