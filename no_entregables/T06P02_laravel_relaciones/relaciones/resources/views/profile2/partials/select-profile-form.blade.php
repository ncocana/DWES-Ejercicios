<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Displayed') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Select the profile to edit.") }}
        </p>
    </header>
    <form class="mt-6 space-y-6">
        <div class="col-sm-6">
            <!-- select -->
            <div class="form-group">
                <x-input-label for="select-profile" :value="__('Profile')" />
                <select id="select-profile" name="select-profile"  class="form-control mt-1 block w-full">
                <option>option 1</option>
                <option>option 2</option>
                <option>option 3</option>
                <option>option 4</option>
                <option>option 5</option>
                </select>
            </div>
        </div>
    </form>
</section>
