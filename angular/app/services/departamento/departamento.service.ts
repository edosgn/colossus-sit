import  {Injectable} from "@angular/core";
import  {Http, Response,Headers} from "@angular/http";
import  "rxjs/add/operator/map";
import  {Observable} from "rxjs/Observable";

@Injectable()
export class DepartamentoService {
	public url = "http://localhost/GitHub/colossus-sit/web/app_dev.php/departamento";
	public identity;
	public token;

	constructor(private _http: Http){}

	getDepartamento(){
		
		return this._http.get(this.url+"/").map(res => res.json());
	}
	
}