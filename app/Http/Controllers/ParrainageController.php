<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProgrammeParrainageRequest;
use App\Models\ProgrammeParrainage;
use App\Services\EditorialData;
use App\Services\Money;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ParrainageController extends Controller
{
    public function index(): View
    {
        return view('parrainage.index', [
            'programmes' => ProgrammeParrainage::orderBy('id')->get(),
        ]);
    }

    public function edit(): View
    {
        return view('admin.parrainage', [
            'programmes' => ProgrammeParrainage::orderBy('id')->get(),
        ]);
    }

    public function update(
        UpdateProgrammeParrainageRequest $request,
        ProgrammeParrainage $programme
    ): RedirectResponse {
        $data = $request->safe()->only(['titre', 'accroche', 'description', 'image_alt']);
        $data['montant_mensuel_centimes'] = $programme->code === ProgrammeParrainage::ENFANT
            ? Money::cents((float) $request->validated('montant_mensuel'))
            : null;

        if ($request->hasFile('image')) {
            $data['image'] = EditorialData::upload($request->file('image'), 'imagesParrainage');
        } elseif ($request->boolean('retirer_image')) {
            $data['image'] = null;
            $data['image_alt'] = null;
        }

        $programme->update($data);

        return redirect()->route('admin.parrainage.edit')
            ->with('success', 'Le programme a été mis à jour sur le site.');
    }
}
