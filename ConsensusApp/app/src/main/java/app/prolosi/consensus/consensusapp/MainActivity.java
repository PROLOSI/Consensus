package app.prolosi.consensus.consensusapp;

import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.net.MalformedURLException;

import app.prolosi.consensus.consensusapp.Api.Autentication;
import app.prolosi.consensus.consensusapp.Utilitario.Utility;

public class MainActivity extends AppCompatActivity {


    Autentication api;
    boolean result;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


        api = new Autentication();

        result = Utility.checkPermission(this);

        if (result) {

            setContentView(R.layout.activity_main);

        }


          new autenticar().execute();


    }

    private class autenticar extends AsyncTask<Void, Void, String> {

        @Override
        protected String doInBackground(Void... voids) {
            api.consumirApi();
            return api.obtenerString("team_url");
        }

        @Override
        protected void onPostExecute(String valor) {

                Toast.makeText(MainActivity.this, valor, Toast.LENGTH_SHORT).show();

        }

    }


    public void metEntrarSession (View view) {

        Button button = (Button) findViewById(R.id.bIniciar_Loggin);
        final EditText usuario = (EditText)findViewById(R.id.tCampoEmailUsuario_Loggin);
        final EditText contrasenia = (EditText)findViewById(R.id.tCampoContrasenia_Loggin);
        final TextView confirmar = (TextView)findViewById(R.id.tConfirmacionAPI);


        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                JSONObject parametros = new JSONObject();

                try {
                    parametros.put("usuario",String.valueOf(usuario.getText()));
                    parametros.put("contrasenia",String.valueOf(contrasenia.getText()));

                } catch (JSONException e) {
                    e.printStackTrace();
                }

                String respuesta = api.enviarDatos(parametros);

                confirmar.setText("Confirmacion: "+respuesta+"");

            }
        });

    }

}
