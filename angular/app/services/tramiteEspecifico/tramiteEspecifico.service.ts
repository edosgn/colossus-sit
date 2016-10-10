import  {Injectable} from "@angular/core";
import  {Http, Response,Headers} from "@angular/http";
import  "rxjs/add/operator/map";
import  {Observable} from "rxjs/Observable";

@Injectable()
export class TramiteEspecificoService {
	public url = "http://localhost/GitHub/colossus-sit/web/app_dev.php/tramiteespecifico";
	public identity;
	public token;

	constructor(private _http: Http){}

	getTramiteEspecifico(){
		
		return this._http.get(this.url+"/").map(res => res.json());
	}

	register(tramiteEspecifico,token){
		
		let json = JSON.stringify(tramiteEspecifico);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/new", params, {headers: headers})
							  .map(res => res.json());
	}

	deleteTramiteEspecifico(token,id){

		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/"+id+"/delete", params, {headers: headers})
							  .map(res => res.json());
	}

	showTramiteEspecifico(token,id){
		
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/show/"+id, params, {headers: headers})
							  .map(res => res.json());

	}

	editTramiteEspecifico(tramiteEspecifico,token){

		let json = JSON.stringify(tramiteEspecifico);
		let params = "json="+json+"&authorization="+token;
		console.log(params);
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
 			return this._http.post(this.url+"/edit", params, {headers: headers})
							  .map(res => res.json());

	}
	
}