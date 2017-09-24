package app.prolosi.consensus.consensusapp;


import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import app.prolosi.consensus.consensusapp.Utilitario.Utility;

public class MainActivity extends AppCompatActivity {


    boolean result;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


        result = Utility.checkPermission(this);

        if (result) {

            setContentView(R.layout.activity_main);

        }

        WebView webView = (WebView) this.findViewById(R.id.webview);
        webView.loadUrl("http://desarrollolibre.net/blog/tema/150/javascript/como-hacer-una-sencilla-galeria-con-css-y-6-lineas-de-javascript");
        webView.setWebViewClient(new WebViewClient());

        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);



    }


}
