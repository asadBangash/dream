@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])
@section('content')
    <!-- from section -->
    <div class="px-5 py-4 d-flex flex-column justify-content-left  gap-3 content-body">

        <h3>{{ ___('installer.Open Database') }}</h3>
        <img src="{{ asset('public/installer/images/Import.png') }}" alt="">

        <h3>{{ ___('installer.Find SQL') }}</h3>
        <p>{{ ___('installer.01)') }} {{ ___('installer.Find the sql file, go to ') }}
            <code>Main_File/database/crm.sql</code>
        </p>
        <p>{{ ___('installer.02)') }} {{ ___('installer.Login into your ') }}
            <code>{{ ___('installer.phpMyAdmin') }}</code>
        </p>
        <p>{{ ___('installer.03)') }} {{ ___('installer.Create and Select your ') }}
            <code>{{ ___('installer.Database') }}</code>
            {{ ___('installer.If aleady exist any data then truncate database') }}
        </p>
        <p>{{ ___('installer.04)') }} {{ ___('installer.Import SQL file ') }}
            <code>Main_File/database/crm.sql</code>
        </p>
        <p>{{ ___('installer.05)') }} {{ ___('installer.Disbale - Partial import & Enable foreign key checks ') }}
        </p>
        <p>{{ ___('installer.06)') }} {{ ___('installer.Click Import button to import sql') }} </p>


        <h4 class="mt-3">{{ ___('installer.After Import SQL') }}</h4>
        <form action="{{ route('service.import_sql_post') }}" method="POST">
            @csrf

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn color mb-3 btn-primary px-5 py-3 align-items-start follow-next-step submit">
                    {{ @$data['button_text'] }} </button>
            </div>
        </form>

    </div>

@stop
