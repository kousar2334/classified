 <form id="editForm">
     @csrf
     <input type="hidden" name="id" value="{{ $city->id }}">
     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Name') }}</label>
             <input type="text" name="name" class="form-control" placeholder="{{ translation('Enter Name') }}"
                 value="{{ $city->name }}">
         </div>

         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Country') }}</label>
             <select name="country" class="form-control country-select">
                 <option value="">{{ translation('Select Country') }}</option>
                 @foreach ($countries as $country)
                     <option value="{{ $country->id }}" @selected($city->state?->country_id == $country->id)>{{ $country->name }}</option>
                 @endforeach
             </select>
         </div>

         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('State') }}</label>
             <select name="state_id" class="form-control state-select">
                 @foreach ($states as $state)
                     <option value="{{ $state->id }}" @selected($city->state_id == $state->id)>{{ $state->name }}</option>
                 @endforeach
             </select>
         </div>
     </div>
     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Status') }}</label>
             <select name="status" class="form-control" required>
                 <option value="{{ config('settings.general_status.active') }}" @selected($city->status == config('settings.general_status.active'))>
                     {{ translation('Active') }}
                 </option>
                 <option value="{{ config('settings.general_status.in_active') }}" @selected($city->status == config('settings.general_status.in_active'))>
                     {{ translation('Inactive') }}
                 </option>
             </select>
         </div>
     </div>
     <div class="btn-area d-flex justify-content-between">
         <button class="btn btn-primary mt-2">{{ translation('Save Changes') }}</button>
     </div>

 </form>
