<?php

namespace App\Http\Controllers\Backend;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CityRequest;
use App\Http\Requests\StateRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequest;
use Illuminate\Http\RedirectResponse;
use App\Repository\LocationRepository;
use BeyondCode\QueryDetector\Outputs\Json;

class LocationController extends Controller
{
    public function __construct(public LocationRepository $location_repository) {}
    /**
     * Will return country list page
     */
    public function countries(Request $request): View
    {
        $countries = $this->location_repository->countryList($request, [1, 0]);
        return view('backend.modules.location.countries.list', ['countries' => $countries]);
    }
    /**
     * Will redirect new country page
     */
    public function addNewCountry(): View
    {
        return view('backend.modules.location.countries.new');
    }
    /**
     * Will store new country
     */
    public function storeNewCountry(CountryRequest $request): JsonResponse
    {
        $res = $this->location_repository->storeCountryData($request->validated());

        if ($res) {
            return response()->json([
                'success' => true,
                'message' => translation('Country added successfully'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => translation('Country added failed'),
        ]);
    }
    /**
     * Will redirect edit country page
     *
     */
    public function editCountry(Request $request): JsonResponse
    {
        $country = $this->location_repository->countryDetails($request->id);
        return response()->json([
            'success' => true,
            'html' => view('backend.modules.location.countries.edit', ['country' => $country])->render(),
        ]);
    }
    /**
     * Will update country
     * 
     */
    public function updateCountry(CountryRequest $request): JsonResponse
    {
        $res = $this->location_repository->updateCountry($request);
        if ($res == true) {
            return response()->json([
                'success' => true,
                'message' => translation('Country updated successfully'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => translation('Country update failed'),
        ]);
    }
    /**
     * Will delete a country
     */
    public function deleteCountry(Request $request): RedirectResponse
    {
        $res = $this->location_repository->deleteCountry($request['id']);

        if ($res) {
            toastNotification('success', 'Country deleted successfully', 'Success');
        } else {
            toastNotification('error', 'Country delete failed', 'Error');
        }
        return to_route('classified.locations.country.list');
    }
    /**
     * Change language status
     */
    public function countryStatusChange(Request $request): JsonResponse
    {
        $res = $this->location_repository->changeCountryStatus($request->id);
        if ($res == true) {
            toastNotification('success',  translation('Status updated successfully'), 'Success');
            return response()->json([
                'success' => true,
            ]);
        } else {
            toastNotification('success', translation('Status update failed'), 'failed');
            return response()->json([
                'success' => false
            ]);
        }
    }
    /**
     * Will fire country bulk actions
     */
    public function countryBulkActions(Request $request): JsonResponse
    {
        $res = $this->location_repository->countryBulkAction($request);
        return response()->json(
            [
                'success' => $res,
            ]
        );
    }
    /**
     * Will return state list
     */
    public function states(Request $request): View
    {
        return view('backend.modules.location.states.list')->with(
            [
                'states' => $this->location_repository->statesList($request)
            ]
        );
    }

    /**
     * Will redirect new state form page
     */
    public function addNewState(): View
    {
        return view('backend.modules.location.states.new')->with(
            [
                'countries' => $this->location_repository->countries()
            ]
        );
    }

    /**
     * Store new state
     */
    public function storeNewState(StateRequest $request): RedirectResponse
    {
        $res = $this->location_repository->storeState($request->validated());
        if ($res == true) {
            toastNotification('success', translation('State added successfully'), 'Success');
            return redirect()->route('classified.locations.state.list');
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Will delete a store
     */
    public function deleteState(Request $request): RedirectResponse
    {
        $res = $this->location_repository->deleteState($request->id);
        if ($res == true) {
            toastNotification('success', translation('State deleted successfully'), 'Success');
            return redirect()->route('classified.locations.state.list');
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Will change state status
     */
    public function stateStatusChange(Request $request): JsonResponse
    {
        $res = $this->location_repository->changeStateStatus($request->id);
        if ($res == true) {
            toastNotification('success', translation('Status updated successfully'), 'Success');
            return response()->json([
                'success' => true
            ]);
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return response()->json([
                'success' => false
            ]);
        }
    }
    /**
     * Will redirect state edit page
     */
    public function editState($id): View
    {
        return view('backend.modules.location.states.edit')->with(
            [
                'countries' => $this->location_repository->countries(),
                'stateDetails' => $this->location_repository->stateDetails($id)
            ]
        );
    }
    /**
     * will update state
     */
    public function updateState(StateRequest $request): RedirectResponse
    {
        $res = $this->location_repository->updateState($request);
        if ($res == true) {
            toastNotification('success', translation('State updated successfully'), 'Success');
            return redirect()->route('classified.locations.state.edit', ['id' => $request['id'], 'lang' => $request['lang']]);
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return redirect()->back();
        }
    }
    /**
     * Will fire states bulk actions
     */
    public function stateBulkActions(Request $request): JsonResponse
    {
        $res = $this->location_repository->statesBulkAction($request);
        return response()->json(
            [
                'success' => $res,
            ]
        );
    }


    /**
     * Will return cities list
     * 
     * @return mixed
     */
    public function cities(Request $request)
    {
        return view('backend.modules.location.cities.list')->with(
            [
                'cities' => $this->location_repository->citiesList($request)
            ]
        );
    }
    /**
     * Will redirect new city page
     */
    public function addNewCity(): View
    {
        return view('backend.modules.location.cities.new')->with(
            [
                'states' => $this->location_repository->states([config('settings.general_status.active')])
            ]
        );
    }
    /**
     * Will store new city information
     */
    public function storeNewCity(CityRequest $request): RedirectResponse
    {
        $res = $this->location_repository->storeCity($request->validated());
        if ($res == true) {
            toastNotification('success', translation('City added successfully'), 'Success');
            return redirect()->route('classified.locations.city.list');
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return redirect()->back();
        }
    }
    /**
     * Will delete city
     */
    public function deleteCity(Request $request): RedirectResponse
    {
        $res = $this->location_repository->deleteCity($request->id);
        if ($res == true) {
            toastNotification('success', translation('City deleted successfully'), 'Success');
            return redirect()->route('classified.locations.city.list');
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return redirect()->back();
        }
    }
    /**
     * Will change city's status
     */
    public function cityStatusChange(Request $request): JsonResponse
    {
        $res = $this->location_repository->changeCityStatus($request->id);
        if ($res == true) {
            toastNotification('success', translation('Status updated successfully'), 'Success');
            return response()->json([
                'success' => true,
            ]);
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return response()->json([
                'success' => false,
            ]);
        }
    }
    /**
     * Will redirect edit city page
     * 
     */
    public function editCity(Int $id): View
    {
        return view('backend.modules.location.cities.edit')->with(
            [
                'states' => $this->location_repository->states([config('settings.general_status.active')]),
                'city_details' => $this->location_repository->cityDetails($id)
            ]
        );
    }
    /**
     * will update city
     */
    public function updateCity(CityRequest $request): RedirectResponse
    {
        $res = $this->location_repository->updateCity($request);
        if ($res == true) {
            toastNotification('success', translation('City updated successfully'), 'Success');
            return redirect()->route('classified.locations.city.edit', ['id' => $request['id'], 'lang' => $request['lang']]);
        } else {
            toastNotification('error', translation('Action failed'), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Will fire cities bulk actions
     */
    public function cityBulkActions(Request $request): JsonResponse
    {
        $res = $this->location_repository->citiesBulkAction($request);
        return response()->json(
            [
                'success' => $res,
            ]
        );
    }
}
