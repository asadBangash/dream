
    @foreach ($data as $item)
        <option value="{{ $item->section->id }}">{{ $item->section->name }}</option>
    @endforeach