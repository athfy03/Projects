<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>HealthNavigator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: Arial, sans-serif; background: #eef7f6; margin:0; }
    header { padding: 14px 18px; background:white; display:flex; align-items:center; justify-content:center; position:sticky; top:0; border-bottom:1px solid #e5e5e5; }
    header strong { color:#118a7e; font-size:18px; }
    .wrap { max-width: 980px; margin: 0 auto; padding: 28px 18px; text-align:center; }
    .card { background:white; border-radius:14px; padding:18px; box-shadow: 0 6px 18px rgba(0,0,0,0.06); display:inline-block; min-width: 320px; }
    .q { font-size: 18px; margin: 0 0 14px; }
    .grid { display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; margin-top: 10px; }
    .btn { width:100%; padding:12px 12px; border-radius:12px; border:1px solid #cfe7e4; background:#f6fffe; cursor:pointer; font-size:15px; }
    .btn:hover { background:#e9fffb; }
    .row { display:flex; justify-content:space-between; gap:10px; margin-top: 14px; }
    .small { font-size: 12px; color:#666; margin-top: 20px; line-height:1.4; }
    .debug { text-align:left; margin-top: 18px; font-size: 13px; background:#f7f7f7; padding: 12px; border-radius: 12px; }
    .pill { display:inline-block; padding: 2px 8px; border-radius: 999px; background:#e7f7f4; color:#0c6d64; font-size: 12px; margin-left: 6px; }
    a { color:#118a7e; text-decoration:none; }
    .topbar { display:flex; justify-content:space-between; align-items:center; width:100%; max-width:980px; margin:0 auto; }
  </style>
</head>
<body>
  <header>
    <div class="topbar">
      <div></div>
      <strong>HealthNavigator</strong>
      <div>
        @auth
            <div style="display: flex; gap: 12px;">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                    <button class="btn" type="submit" style="width:auto; padding:10px 14px;">
                      Logout
                    </button>
                </form>
            </div>
        @else
            <button class="btn" type="submit"><a href="{{ route('login') }}" style="padding: 10px 14px;">Login</a></button>
        @endauth
      </div>
    </div>
  </header>

  <div class="wrap">
    @yield('content')

    <div class="small">

    </div>
  </div>
</body>
</html>