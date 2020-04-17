
//import custom policies created
import policies from './policies';

export default{
    install (Vue,options){
        Vue.prototype.authorize=function(policy,model){
            //make sure user has signed in
            if(!window.Auth.signedIn) return false;
        
            //check the arugments that policy is string and model is object
            if(typeof policy==='string' && typeof model==='object'){
                const user=window.Auth.user;
                
                //return policies[policy](user,model);
                return true;
            }
        };
        Vue.prototype.signedIn=window.Auth.signedIn;
    }
}
