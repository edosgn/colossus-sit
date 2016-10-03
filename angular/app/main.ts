import { AppComponent } from './app.component';
import { APP_ROUTER_PROVIDERS } from './app.routes';
import { HTTP_PROVIDERS } from '@angular/http';
import { bootstrap }    from '@angular/platform-browser-dynamic';

bootstrap(AppComponent, [HTTP_PROVIDERS,APP_ROUTER_PROVIDERS])
.catch(err => console.log(err));
