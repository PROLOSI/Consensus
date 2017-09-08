package app.consensus.prolosi.consensusapp;

import app.consensus.prolosi.consensusapp.authenticator.BootstrapAuthenticatorActivity;
import app.consensus.prolosi.consensusapp.core.TimerService;
import app.consensus.prolosi.consensusapp.ui.BootstrapActivity;
import app.consensus.prolosi.consensusapp.ui.BootstrapFragmentActivity;
import app.consensus.prolosi.consensusapp.ui.BootstrapTimerActivity;
import app.consensus.prolosi.consensusapp.ui.CheckInsListFragment;
import app.consensus.prolosi.consensusapp.ui.MainActivity;
import app.consensus.prolosi.consensusapp.ui.NavigationDrawerFragment;
import app.consensus.prolosi.consensusapp.ui.NewsActivity;
import app.consensus.prolosi.consensusapp.ui.NewsListFragment;
import app.consensus.prolosi.consensusapp.ui.UserActivity;
import app.consensus.prolosi.consensusapp.ui.UserListFragment;

import javax.inject.Singleton;

import dagger.Component;

@Singleton
@Component(
        modules = {
                AndroidModule.class,
                BootstrapModule.class
        }
)
public interface BootstrapComponent {

    void inject(BootstrapApplication target);

    void inject(BootstrapAuthenticatorActivity target);

    void inject(BootstrapTimerActivity target);

    void inject(MainActivity target);

    void inject(CheckInsListFragment target);

    void inject(NavigationDrawerFragment target);

    void inject(NewsActivity target);

    void inject(NewsListFragment target);

    void inject(UserActivity target);

    void inject(UserListFragment target);

    void inject(TimerService target);

    void inject(BootstrapFragmentActivity target);
    void inject(BootstrapActivity target);


}
