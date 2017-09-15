package app.consensus.prolosi.consensusapp;

import android.accounts.AccountsException;
import android.app.Activity;

import app.consensus.prolosi.consensusapp.core.BootstrapService;

import java.io.IOException;

public interface BootstrapServiceProvider {
    BootstrapService getService(Activity activity) throws IOException, AccountsException;
}
