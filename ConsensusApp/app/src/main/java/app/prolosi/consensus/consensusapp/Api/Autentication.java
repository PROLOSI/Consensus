package app.prolosi.consensus.consensusapp.Api;

import android.util.JsonReader;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;

import javax.net.ssl.HttpsURLConnection;

/**
 * Created by jeison on 15/09/17.
 */

public class Autentication {


    URL urlApiConnect;
    HttpsURLConnection myConnection;
    InputStream responseBody;
    InputStreamReader responseBodyReader;
    JsonReader jsonReader;


    //Produccion
    public Autentication(URL urlApiConnect) {

        try {

            this.urlApiConnect = urlApiConnect;
            myConnection = (HttpsURLConnection) urlApiConnect.openConnection();
            myConnection.setRequestMethod("POST");
            myConnection.setRequestProperty("Accept", "application/json");

        } catch (MalformedURLException mal){

            mal.printStackTrace();

        } catch (IOException io) {

            io.printStackTrace();
        }

    }

    //Desarrollo
    public Autentication()   {

        try {

            urlApiConnect = new URL("https://api.github.com/");
            myConnection = (HttpsURLConnection) urlApiConnect.openConnection();
            myConnection.setRequestProperty("Accept", "application/json");


        } catch (IOException e) {

            e.printStackTrace();
        }


    }

    public void encabezados () {

        myConnection.setRequestProperty("User-Agent", "my-rest-app-v0.1");
        myConnection.setRequestProperty("Accept", "application/vnd.github.v3+json");
        myConnection.setRequestProperty("Contact-Me",  "hathibelagal@example.com");

    }

    public void consumirApi(){

        try {

            responseBody = myConnection.getInputStream();
            responseBodyReader = new InputStreamReader(responseBody, "UTF-8");
            jsonReader = new JsonReader(responseBodyReader);

        } catch (IOException e) {
            e.printStackTrace();
        }



    }

    public String obtenerString(String valor){

        String value = "";

        try {


            if (myConnection.getResponseCode() == 200) {

                jsonReader.beginObject(); // Start processing the JSON object
                while (jsonReader.hasNext()) { // Loop through all keys
                    String key = jsonReader.nextName(); // Fetch the next key
                    if (key.equals(valor)) { // Check if desired key

                        value = jsonReader.nextString();

                        break; // Break out of the loop
                    } else {

                        jsonReader.skipValue(); // Skip values of other keys
                    }
                }


            } else {

                value="NO_ELEMENT_IN_BOUND";

            }

        } catch (IOException e) {
            e.printStackTrace();
        }


        return value;
    }


    public String enviarDatos(JSONObject parametros) {

        String result = "";
        String myData="";

        try {



            // Create the data
            myData = parametros.toString();

            myConnection.setRequestMethod("POST");
            // Enable writing
            myConnection.setDoOutput(true);

            // Write the data
            myConnection.getOutputStream().write(myData.getBytes());

            if (myConnection.getResponseCode() == 200) {

                result = "true";

            } else {
                result = myData;
            }



        } catch (IOException e) {

            result = myData;
            e.printStackTrace();

        }


        return result;

    }



}
