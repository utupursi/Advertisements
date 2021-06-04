@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            {{--            <div class="d-grid gap-2 col-sm-6 mx-auto">--}}
            {{--                <h4 style="margin-bottom: 15px">Please Choose Type of Advert</h4>--}}
            {{--                <button style="width: 180px;border:1px solid grey;padding-top:5px;padding-bottom: 5px;"--}}
            {{--                        class="btn btn-info">Vacancy--}}
            {{--                </button>--}}
            {{--                <button--}}
            {{--                    style="margin-left: -4px;border:1px solid grey;width: 180px;padding-top:5px;padding-bottom: 5px;"--}}
            {{--                    class="btn btn-light">Looking for a job--}}
            {{--                </button>--}}
            {{--            </div>--}}
            <br>
            <div class="d-grid gap-2 col-sm-6 mx-auto">
                <form action="{{route('advertCreate')}}" method="POST" novalidate>
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                       class="col-sm-2 col-form-label col-form-label-sm">Location</label>
                                <div class="col-sm-6">

                                    <select style="overflow: auto" class="form-control overflow-auto {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                            name="city">
                                        <option selected value="" disabled>Location</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->title}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('city'))
                                        <div class="error-block">
                                            {{$errors->first('city') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                       class="col-sm-2 col-form-label col-form-label-sm">Category</label>
                                <div class="col-sm-6">
                                    <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                            name="category">
                                        <option value="" selected disabled>Category</option>
                                        @foreach($categories as $category)
                                            <option
                                                {{old('category')==$category->id?"selected":""}} value="{{$category->id}}">{{$category->title}}
                                            </option>
                                        @endforeach</select>

                                    @if ($errors->has('category'))
                                        <div class="error-block">
                                            {{$errors->first('category') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                       class="col-sm-2 col-form-label col-form-label-sm">Work schedule</label>
                                <div class="col-sm-6">
                                    <select class="form-control {{ $errors->has('work_schedule') ? 'is-invalid' : '' }}"
                                            name="work_schedule">
                                        <option value="" selected disabled>Work Schedule</option>
                                        <option {{old('work_schedule')=="full_time"?"selected":""}} value="full_time">
                                            Full Time
                                        </option>
                                        <option {{old('work_schedule')=="part_time"?"selected":""}} value="part_time">
                                            Part Time
                                        </option>
                                        <option {{old('work_schedule')=="remote"?"selected":""}} value="remote">Remote
                                        </option>
                                    </select>

                                    @if ($errors->has('work_schedule'))
                                        <div class="error-block">
                                            {{$errors->first('work_schedule') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                       class="col-sm-2 col-form-label col-form-label-sm">Experience</label>
                                <div class="col-sm-6">

                                    <select class="form-control {{ $errors->has('experience') ? 'is-invalid' : '' }}"
                                            name="experience">
                                        <option value="" selected disabled>Experience</option>
                                        <option
                                            {{old('experience')=="without_experience"?"selected":""}} value="without_experience">{{\App\Models\Advertisement::WITHOUT_EXPERIENCE}}</option>
                                        <option
                                            {{old('experience')=="less_than_one_year"?"selected":""}} value="less_than_one_year">{{\App\Models\Advertisement::LESS_THAN_ONE_YEAR}}</option>
                                        <option
                                            {{old('experience')=="one_three_year"?"selected":""}} value="one_three_year">{{\App\Models\Advertisement::ONE_THREE_YEAR}}</option>
                                        <option
                                            {{old('experience')=="three_five_year"?"selected":""}} value="three_five_year">{{\App\Models\Advertisement::THREE_FIVE_YEAR}}</option>
                                        <option
                                            {{old('experience')=="five_ten_year"?"selected":""}} value="five_ten_year">{{\App\Models\Advertisement::FIVE_TEN_YEAR}}</option>
                                        <option
                                            {{old('experience')=="more_than_ten_year"?"selected":""}} value="more_than_ten_year">{{\App\Models\Advertisement::MORE_THAN_TEN_YEAR}}</option>
                                    </select>
                                    @if ($errors->has('experience'))
                                        <div class="error-block">
                                            {{$errors->first('experience') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="colFormLabelSm"
                                       class="col-sm-2 col-form-label col-form-label-sm">Title</label>
                                <div class="col-sm-6">
                                    <input type="text"
                                           class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }} "
                                           id="colFormLabelSm"
                                           placeholder="Title" name="title" value="{{old('title')}}">
                                    @if ($errors->has('title'))
                                        <div class="error-block">
                                            {{$errors->first('title') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <h4 style="margin-bottom: 15px">Description</h4>
                            <div class="form-group">
                                <label style="margin-left: -14px" for="colFormLabelSm"
                                       class="col-sm-4 col-form-label col-form-label-sm">General description
                                </label>
                                <div class="col-sm-8" style="margin-left: -14px">
                                    <textarea id="w3review" name="description"
                                              class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                              rows="4">{{old('description')}}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="error-block">
                                            {{$errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="margin-left: -14px" for="colFormLabelSm"
                                       class="col-sm-4 col-form-label col-form-label-sm">Duties
                                </label>
                                <div class="col-sm-8" style="margin-left: -14px">
                                    <textarea id="w3review" name="duties"
                                              class="form-control {{ $errors->has('duties') ? 'is-invalid' : '' }}"
                                              rows="4">{{old('duties')}}</textarea>
                                    @if ($errors->has('duties'))
                                        <div class="error-block">
                                            {{$errors->first('duties') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="margin-left: -14px" for="colFormLabelSm"
                                       class="col-sm-4 col-form-label col-form-label-sm">Requirements
                                </label>
                                <div class="col-sm-8" style="margin-left: -14px">
                                    <textarea id="w3review" name="requirements"
                                              class="form-control {{ $errors->has('requirements') ? 'is-invalid' : '' }}"
                                              rows="4">{{old('requirements')}}</textarea>
                                    @if ($errors->has('requirements'))
                                        <div class="error-block">
                                            {{$errors->first('requirements') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h4 style="margin-bottom: 15px">Salary</h4>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="salary_type" value="month"
                                       id="month">
                                <label class="form-check-label" for="month">
                                    Month
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="salary_type" value="day" id="day">
                                <label class="form-check-label" for="day">
                                    Day
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="salary_type" value="by_agreement"
                                       id="by_agreement">
                                <label class="form-check-label" for="by_agreement">
                                    By agreement
                                </label>
                            </div>
                            @if ($errors->has('salary_type'))
                                <div class="error-block">
                                    {{$errors->first('salary_type') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="col-sm-8" style="margin-left: -14px;margin-top:10px">
                                    <input type="number"
                                           name="salary"
                                           class="form-control {{ $errors->has('salary') ? 'is-invalid' : '' }}"
                                           id="colFormLabelSm"
                                           placeholder="salary">
                                    @if ($errors->has('salary'))
                                        <div class="error-block">
                                            {{$errors->first('salary') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <h4>Contact Info</h4>
                            <div class="form-group">
                                <div class="col-sm-8" style="margin-left: -14px">
                                    <label style="margin-left: -14px" for="colFormLabelSm"
                                           class="col-sm-4 col-form-label col-form-label-sm">Phone
                                    </label>
                                    <input type="text" name="phone"
                                           class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }} "
                                           id="colFormLabelSm"
                                           placeholder="phone">
                                    @if ($errors->has('phone'))
                                        <div class="error-block">
                                            {{$errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8" style="margin-left: -14px">
                                    <label style="margin-left: -14px" for="colFormLabelSm"
                                           class="col-sm-4 col-form-label col-form-label-sm">Email
                                    </label>
                                    <input type="email" name="email" class="form-control " id="colFormLabelSm"
                                           placeholder="email">
                                </div>
                            </div>
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>

@endsection
