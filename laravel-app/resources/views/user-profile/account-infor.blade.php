@extends('user-profile.layout')
@section('content')
    <style>
        .account-settings-root>div>b {
            color: #23304a;
            font-size: 1.125rem;
            line-height: 1.75rem;
            font-weight: 600;
        }

        .account-settings-root>div>hr {
            border: none;
            border-top: 1.5px solid rgb(226 232 240);
            margin: 0px 0 2px 0;
        }

        .account-settings-root>div:first-child>div {
            display: flex;
            align-items: center;
            gap: 18px;
            background: #fcfdfe;
            border: 1.5px solid #e1e7ee;
            border-radius: 10px;
            padding: 8px 14px;
            max-width: 350px;
        }

        .account-settings-root>div:first-child>div>input[type="text"] {
            border: none;
            background: transparent;
            font-size: 1.05rem;
            color: #263352;
            flex: 1;
            outline: none;
        }

        .account-settings-root>div:first-child>div>button {
            background: #14815e;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 7px;
            padding: 6px 20px;
            font-size: 1rem;
            transition: background 0.18s;
            cursor: pointer;
            margin-left: 12px;
        }

        .account-settings-root>div:first-child>div>button:hover {
            background: #11905e;
        }

        .account-settings-root>div:nth-child(2)>span {
            color: #8190a5;
            font-size: 1.07rem;
        }

        .account-settings-root>div:nth-child(3)>button {
            background: #fa5252;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 7px 20px;
            font-size: 1rem;
            transition: background 0.18s;
            cursor: pointer;
            margin-top: 12px;
        }

        .account-settings-root>div:nth-child(3)>button:hover {
            background: #e53e3e;
        }

        .form_changePassword {
            margin-top: 12px;
            max-width: 520px;
        }

        .form_changePassword>div {}

        .form_changePassword>div>label {
            display: block;
            font-weight: 600;
            color: #102043;
            margin-bottom: 7px;
            font-size: 1.09rem;
        }

        .form_changePassword>div>input[type="password"] {
            width: 100%;
            background: #f7fafd;
            border: 1.2px solid #dbe3ed;
            border-radius: 10px;
            padding: 5px 18px;
            font-size: 1.15rem;
            color: #96aac4;
            outline: none;
            margin-top: 3px;
            font-family: inherit;
            letter-spacing: 0.14em;
        }

        .form_changePassword>button[type="submit"] {
            margin-top: 14px;
            background: #11805a;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 6px 20px;
            font-size: 1.13rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            transition: background 0.19s;
            margin-bottom: 8px;
        }

        .form_changePassword>button[type="submit"]:hover {
            background: #116c4d;
        }

        .form_changePassword>button[type="submit"] i {
            font-size: 1.18em;
            margin-left: 8px;
        }

        .account-name>div>.form_changeName {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f7fafd;
            border: 1px solid #d6e0ea;
            border-radius: 10px;
            padding: 5px 10px;
            max-width: 523px;
            margin: 8px 0 0 0;
            box-sizing: border-box;
        }

        .account-name>div>.form_changeName>input[type="text"] {
            border: none;
            background: transparent;
            font-size: 1.15rem;
            color: #22334c;
            outline: none;
            flex: 1;
            font-family: inherit;
        }

        .account-name>div>.form_changeName>button {
            background: #057853;
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 6px 20px;
            font-size: 1.13rem;
            cursor: pointer;
            transition: background 0.16s;
            margin-left: 14px;
        }

        .account-name>div>.form_changeName>button:hover {
            background: #055e40;
        }
    </style>
    <div>
        <b class="text-lg">Change account name</b>
        <hr>
        <div class="account-name">
            <div>
                <form class="form_changeName" action="{{ route('profile.update.fullname') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input name="fullname" type="text" value="{{ Auth::user()->fullname }}">
                    <button type="submit">Update</button>
                </form>
            </div>

            @error('fullname')
                <div style="color: #e53e3e; margin-top: 5px;">
                    {{ $message }}
                </div>
            @enderror

        </div>
    </div>
    <div>
        <b>Change password</b>
        <hr>
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p style="color: #e53e3e; margin-top: 2px;">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form class="form_changePassword" action="{{ route('profile.update.password') }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label>Current password</label>
                <input type="password" name="old_password" value=""
                    placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
            </div>
            <div>
                <label>New password</label>
                <input type="password" value="" name="new_password"
                    placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
            </div>
            <div>
                <label>Confirm new password</label>
                <input type="password" value="" name="confirm_new_password"
                    placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
            </div>
            <button type="submit">
                Change password&nbsp; <i class="fa fa-arrow-right"></i>
            </button>
        </form>
        {{-- <span>You signed in with Google. You can change your password in your Google account.</span> --}}


    </div>
    <div>
        <b>Danger Zone</b>
        <hr>
        <button class="btn btn-danger" style="border-radius: 14px">Delete account</button>
    </div>
    <script></script>
@endsection
