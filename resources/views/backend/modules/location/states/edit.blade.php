 <form id="editForm">
     @csrf
     <input type="hidden" name="id" value="{{ $state->id }}">

     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Name') }}</label>
             <input type="text" name="name" class="form-control" placeholder="{{ translation('Enter name') }}"
                 value="{{ $state->name }}">
         </div>
     </div>

     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Country') }}</label>
             <select name="country" class="form-control country-select">
                 @foreach ($countries as $country)
                     <option value="{{ $country->id }}" @selected($state->country_id == $country->id)>{{ $country->name }}</option>
                 @endforeach
             </select>
         </div>
     </div>

     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Status') }}</label>
             <select name="status" class="form-control" required>
                 <option value="{{ config('settings.general_status.active') }}" @selected($state->status == config('settings.general_status.active'))>
                     {{ translation('Active') }}
                 </option>
                 <option value="{{ config('settings.general_status.in_active') }}" @selected($state->status == config('settings.general_status.in_active'))>
                     {{ translation('Inactive') }}
                 </option>
             </select>
         </div>
     </div>
     <div class="btn-area d-flex justify-content-between">
         <button class="btn btn-primary mt-2 store-category">{{ translation('Save Changes') }}</button>
     </div>

 </form>
