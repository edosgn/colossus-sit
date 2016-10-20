import  {Injectable} from "@angular/core";
import  {Http, Response,Headers} from "@angular/http";
import  "rxjs/add/operator/map";
import  {Observable} from "rxjs/Observable";

@Injectable()
export class TramiteGeneralService {
	public url = "http://localhost/GitHub/colossus-sit/web/app_dev.php/tramitegeneral";
	public identity;
	public token;

	constructor(private _http: Http){}

	getTramiteGeneral(){
		
		return this._http.get(this.url+"/").map(res => res.json());
	}

	register(tramiteGeneral,token){
		
		let json = JSON.stringify(tramiteGeneral);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/new", params, {headers: headers})
							  .map(res => res.json());
	}

	deleteTramiteGeneral(token,id){

		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/"+id+"/delete", params, {headers: headers})
							  .map(res => res.json());
	}

	showTramiteGeneral(token,id){
		
		let params = "authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/show/"+id, params, {headers: headers})
							  .map(res => res.json());

	}

	editTramiteGeneral(tramiteGeneral,token){

		let json = JSON.stringify(tramiteGeneral);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
 			return this._http.post(this.url+"/edit", params, {headers: headers})
							  .map(res => res.json());

	}
	showTramiteGeneralVehiculo(token,vechiculoid){
		let json = JSON.stringify(vechiculoid);
		let params = "json="+json+"&authorization="+token;
		let headers = new Headers({'Content-Type':'application/x-www-form-urlencoded'});
		return this._http.post(this.url+"/tramitesG/placa", params, {headers: headers})
							  .map(res => res.json());

	}
	
}