 <form id="member-update-form">
     <div class="form-row mb-20">
         <label class="black font-14 col-12">{{ translate('Image') }}</label>
         @include('core::base.includes.media.media_input', [
             'input' => 'edit_image',
             'data' => $member->image,
         ])

     </div>
     <div class="form-row mb-20">
         <label class="black font-14">{{ translate('Name') }}</label>
         <input type="hidden" name="id" value="{{ $member->id }}">
         <input type="text" name="name" value="{{ $member->name }}" class="form-control">
     </div>
     <div class="form-row mb-20">
         <label class="black font-14">{{ translate('Email') }}</label>
         <input type="email" name="email" value="{{ $member->email }}" class="form-control">
     </div>
     <div class="form-row mb-20">
         <label class="col-12 black font-14">{{ translate('Phone') }}</label>
         <input type="text" name="phone" value="{{ $member->phone }}" class="form-control">
     </div>
     <div class="form-row mb-20">
         <label class="col-12 black font-14">{{ translate('Status') }}</label>
         <select name="status" class="form-control">
             <option value="{{ config('settings.general_status.active') }}" @selected($member->status == config('settings.general_status.active'))>
                 {{ translate('Active') }}
             </option>
             <option value="{{ config('settings.general_status.in_active') }}" @selected($member->status == config('settings.general_status.in_active'))>
                 {{ translate('Inactive') }}
             </option>
         </select>
     </div>
     <div class="btn-area d-flex justify-content-between">
         <button class="btn long mt-2 update-member">{{ translate('Save Changes') }}</button>
     </div>

 </form>
