<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
      body {background-color: #fff; color: #222; font-family: sans-serif;}
      pre {margin: 0; font-family: monospace;}
      a:link {color: #009; text-decoration: none; background-color: #fff;}
      a:hover {text-decoration: underline;}
      table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
      .center {text-align: center;}
      .center table {margin: 1em auto; text-align: left;}
      .center th {text-align: center !important;}
      td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
      th {top: 0; background: inherit;}
      h1 {font-size: 150%;}
      h2 {font-size: 125%;}
      .p {text-align: left;}
      .e {background-color: #ccf; width: 300px; font-weight: bold;}
      .h {background-color: #99c; font-weight: bold;}
      .r {background-color: #000; width: 300px; font-weight: bold;}
      .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
      .v i {color: #999;}
      img {float: right; border: 0;}
      hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
    </style>
    <title>{{ config('app.name') }} - Configuration</title>
    <meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE">
  </head>
  <body>
    <div class="center">
      <table>
        <tbody>
          <tr class="h">
            <td>
              <h1 class="p">{{ config('app.name') }} - Configuration</h1>
          </td>
          </tr>
        </tbody>
      </table>
      @foreach($config as $section => $config)
        <h2>{{ $section }}</h2>
        <table>
          <tbody>
            <tr class="h">
              <th>Key</th>
              <th>Value</th>
            </tr>
            @foreach($config as $setting => $value)
              <tr>
                <td class="e">{{ $setting }}</td>
                <td class="v">
                  @if($value === null || $value === '')
                    <i>no value</i>
                  @elseif($value === false)
                    false
                  @else
                    {{ $value }}
                  @endif
                </td>
              </tr>
            @endforeach
            <tr class="h">
              <th colspan="2">
                <code>dump(config('{{ $section }}'))</code>
              </th>
            </tr>
            <tr>
              <td colspan="2" class="r">@php dump(config($section)); @endphp</td>
            </tr>
          </tbody>
        </table>
      @endforeach
    </div>
  </body>
</html>
