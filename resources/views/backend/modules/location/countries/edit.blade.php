 <form id="editForm">
     @csrf
     <input type="hidden" name="id" value="{{ $country->id }}">

     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Name') }}</label>
             <input type="text" name="name" class="form-control" placeholder="{{ translation('Enter name') }}"
                 value="{{ $country->name }}">
         </div>
     </div>

     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Country Code') }}</label>
             <input type="text" name="code" class="form-control"
                 placeholder="{{ translation('Enter country code') }}" value="{{ $country->code }}">
         </div>
     </div>

     <div class="form-row">
         <div class="form-group col-lg-12">
             <label class="black font-14">{{ translation('Status') }}</label>
             <select name="status" class="form-control" required>
                 <option value="{{ config('settings.general_status.active') }}" @selected($country->status == config('settings.general_status.active'))>
                     {{ translation('Active') }}
                 </option>
                 <option value="{{ config('settings.general_status.in_active') }}" @selected($country->status == config('settings.general_status.in_active'))>
                     {{ translation('Inactive') }}
                 </option>
             </select>
         </div>
     </div>
     <div class="btn-area d-flex justify-content-between">
         <button class="btn btn-primary mt-2 store-category">{{ translation('Save Changes') }}</button>
     </div>

 </form>
