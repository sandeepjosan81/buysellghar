@extends('panel::layouts.app')
@section('body-class', '')

@section('title', __('panel/menu.leadcontacts'))
@section('page-title-right')
  <!-- <a href="{{ panel_route('leadcontacts.create') }}" class="btn btn-primary"><i class="bi bi-plus-square"></i> {{
    __('panel/common.create') }}</a> -->
@endsection

@section('content')
<div class="card h-min-600" id="app">
  <div class="card-body">

    <x-panel-data-criteria :criteria="$criteria ?? []" :action="panel_route('leadcontacts.index')" />

    @if ($lead_contacts->count())
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <td>{{ __('panel/common.id')}}</td>
            <td>{{ __('panel/leadcontact.name') }}</td>
            <td>{{ __('panel/leadcontact.contact') }}</td>
            <td>{{ __('panel/leadcontact.email') }}</td>            
            <td>{{ __('panel/leadcontact.interested_in') }}</td>
            <td>{{ __('panel/leadcontact.property_url') }}</td>
            <td>{{ __('panel/common.created_at') }}</td>
            <!-- <td>{{ __('panel/common.actions') }}</td> -->
          </tr>
        </thead>
        <tbody>
          @foreach($lead_contacts as $item)
          <tr>
            <td>{{ $item->id }}</td>
            <td><a href="javascript:void(0)" class="text-decoration-none" target="_blank">{{ $item->name ?? '' }}</a></td>
            <td><a href="tel:{{ $item->contact_no }}" class="text-decoration-none" target="_blank">{{ $item->contact_no }}</a></td>
            <td>{{ $item->email }}</td>            
            <td>{{ $item->interested_in }}</td> 
            <td><a href="{{ $item->property_url }}" class="text-decoration-none" target="_blank">View</a></td> 
            <td>{{ date('d-M-y | h:i a', strtotime($item->created_at)) }}</td>          
              <!-- <div class="d-flex gap-2">
                <div>
                  <a href="{{ panel_route('brands.edit', [$item->id]) }}">
                    <el-button size="small" plain type="primary">{{
                      __('panel/common.edit')}}</el-button>
                  </a>
                </div>
                <div>
                  <form ref="deleteForm" action="{{ panel_route('brands.destroy', [$item->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <el-button size="small" type="danger" plain @click="open({{ $item->id }})">{{
                      __('panel/common.delete')}}</el-button>
                  </form>
                </div>
              </div> -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
    {{ $lead_contacts->withQueryString()->links('panel::vendor/pagination/bootstrap-4') }}
    @else
    <x-common-no-data />
    @endif
  </div>
</div>
@endsection
@push('footer')
<script>
  const { createApp, ref } = Vue;
    const { ElMessageBox, ElMessage } = ElementPlus;
    const app = createApp({
    setup() {
    const deleteForm = ref(null);
    const open = (itemId) => {
    console.log(itemId);
     ElMessageBox.confirm(
      '{{ __("common/base.hint_delete") }}',
      '{{ __("common/base.cancel") }}',
      {
        confirmButtonText: '{{ __("common/base.confirm")}}',
        cancelButtonText: '{{ __("common/base.cancel")}}',
        type: 'warning',
      }
      )
    .then(() => {
             const deleteUrl = urls.panel_base + '/brands/' + itemId;
               deleteForm.value.action = deleteUrl;
              deleteForm.value.submit()
    })
    .catch(() => {
    });
    };

    return { open, deleteForm };
    }
    });
    app.use(ElementPlus);
    app.mount('#app');
</script>
@endpush
