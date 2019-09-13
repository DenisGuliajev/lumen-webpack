<?php


namespace App\Http\Controllers;


use App\Pseudomodels\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ControllerHome extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public static function getView() {
        return view(
            'homepage',
            [
                'packagesAvailable' => Order::getSrcArray(),
            ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Laravel\Lumen\Http\Redirector
     */
    public static function getPackagesView(Request $request) {
        $packagesAvailable = Order::getSrcArray();
        $value = $request->userInput ?? null;
        if (null === $value || !is_numeric($value)) {
            return view(
                'homepage',
                [
                    '_error' => 'Invalid input, please provide int value',
                    'packagesAvailable' => $packagesAvailable,
                    'value' => (string)$value,
                ]
            );
        }
        try {
            $packagesRequired = Order::make(intval($value, 10));
        } catch (\Exception $e) {
            return view(
                'homepage',
                [
                    '_error' => 'Internal server error',
                    'packagesAvailable' => $packagesAvailable,
                    'value' => (string)$value,
                ]
            );
        }

        return view(
            'homepage',
            [
                'packagesRequired' => $packagesRequired,
                'packagesAvailable' => $packagesAvailable,
                'value' => $request->userInput,
            ]
        );
    }
}
