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

	register(departamento,token){
		
		let json = JSON.stringify(departamento);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/new", params, {headers: headers})
							  .map(res => res.json());
	}

	deleteDepartamento(token,id){

		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/"+id+"/delete", params, {headers: headers})
							  .map(res => res.json());
	}

	showDepartamento(token,id){
		
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/"+id, params, {headers: headers})
							  .map(res => res.json());

	}
	
}