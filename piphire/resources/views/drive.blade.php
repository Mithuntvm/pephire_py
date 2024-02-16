<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Picker Example</title>

    <script type="text/javascript">

      // The Browser API key obtained from the Google API Console.
      var developerKey = 'AIzaSyDePFjv1BrKkBARQCYeCE9Ir-aOiIIpm4I';

      // The Client ID obtained from the Google API Console. Replace with your own Client ID.
      var clientId = '213288234854-cj2ujuh027remgdfp9gsum2ei48k60e2.apps.googleusercontent.com';

      // Scope to use to access user's drive.
      var scope = 'https://www.googleapis.com/auth/drive';

      var pickerApiLoaded = false;
      var oauthToken;

      // Use the API Loader script to load google.picker and gapi.auth.
      function onApiLoad() {
        gapi.load('auth2', onAuthApiLoad);
        gapi.load('picker', onPickerApiLoad);
      }

      function onAuthApiLoad() {
        var authBtn = document.getElementById('auth');
        authBtn.disabled = false;
        authBtn.addEventListener('click', function() {
          gapi.auth2.init({ client_id: clientId }).then(function(googleAuth) {
            googleAuth.signIn({ scope: scope }).then(function(result) {
              handleAuthResult(result.getAuthResponse());
            })
          })
        });
      }

      function onPickerApiLoad() {
        pickerApiLoaded = true;
        createPicker();
      }

      function handleAuthResult(authResult) {
        if (authResult && !authResult.error) {
          oauthToken = authResult.access_token;
          createPicker();
        }
      }

      // Create and render a Picker object for picking user Documents.
      function createPicker() {

        var totcount = document.getElementById('docmax').value;

        if (pickerApiLoaded && oauthToken) {
          var view = new google.picker.DocsView()
            .setParent('root')
            .setIncludeFolders(true);

          var picker = new google.picker.PickerBuilder().
              addView(view).
              enableFeature(google.picker.Feature.MULTISELECT_ENABLED).
              setOAuthToken(oauthToken).
              setMaxItems(totcount).
              setDeveloperKey(developerKey).
              setCallback(pickerCallback).
              build();
          picker.setVisible(true);
        }
      }

      // A simple callback implementation.
      function pickerCallback(data) {
        var url = '';
        if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
          //console.log(data[google.picker.Response.DOCUMENTS]);
          data[google.picker.Response.DOCUMENTS].forEach(loopdocfiles);
        }

      }

      function loopdocfiles(key, value){
        console.log(key);
        var message = '<br/>You picked: ' + key.url;
        document.getElementById('result').innerHTML += message;
      }

    </script>
  </head>
  <body>
    <button type="button" id="auth" disabled>Authenticate</button>

    <div id="result"></div>
    <input type="hidden" id="docmax" value='4'> 
    <!-- The Google API Loader script. -->
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>
  </body>
</html>