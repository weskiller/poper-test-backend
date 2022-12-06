<?php

namespace App\Http\Controllers;

use App\Constants\SchoolStatus;
use App\Events\School\Created;
use App\Http\Requests\School\StoreRequest;
use App\Http\Resources\School as SchoolResource;
use App\Models\School;
use App\Models\Teacher;

class SchoolController
{
    public function index()
    {
        /** @var Teacher $teacher */
        $teacher = auth()->user();

        $query = School::with('founder')
            ->withCount('students', 'teachers')
            ->whereHas('teachers', static fn($query) => $query->where('teachers.id', $teacher->id));

        return SchoolResource::collection($query->paginate());
    }


    public function store(StoreRequest $request)
    {
        /** @var Teacher $teacher */
        $teacher = $request->user();
        /** @var School $school */
        $school = $teacher->foundedSchools()->create([
            'status' => SchoolStatus::Apply,
            'name' => $request->input('name'),
        ]);
        $school->setRelation('founder', $teacher);
        event(new Created($school));
        return new SchoolResource($school);
    }

}
