/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.myapp.entities.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;


import com.codename1.l10n.ParseException;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.mycompany.myapp.entities.User;
import com.mycompany.myapp.utils.Statics;
import com.mycompany.myapp.utils.UserSession;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;


/**
 *
 * @author bhk
 */
public class UserServices {

   public static UserServices instance;
    private final ConnectionRequest con;
    ArrayList<User> users = new ArrayList<>();
    public boolean ResultOK;
//    private ConnectionRequest req;
    public User user;

    public UserServices() {
        con = new ConnectionRequest();
    }

    public static UserServices getInstance() {
        if (instance == null) {
            instance = new UserServices();
        }
        return instance;
    }
    boolean result;
    
    
     public boolean RegisterAction(String email ,String password,String nom,String prenom,String age,String adresse,String cin) {

        // création d'une nouvelle demande de connexion
        String url = Statics.BASE_URL + ""
                + "user/signup"+"?email="+email+""
                + "&password="+password+""
                + "&nom="+nom+""
                + "&prenom="+prenom+""
                + "&age="+age+""
                + "&adresse="+adresse+""
                + "&cin="+cin+"";
               
con.setUrl(url);
        con.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
    
               result = con.getResponseCode() == 200;
                     String      str = new String(con.getResponseData());//Récupération de la réponse du serveur
                     System.out.println(str);//Affichage de la réponse serveur sur la console
 Dialog.show("Alert", str, new Command("OK"));
 

               con.removeResponseListener(this);

            }
        });
            
        NetworkManager.getInstance().addToQueueAndWait(con);// Ajout de notre demande de connexion à la file d'attente du NetworkManager
        return result;}
    
    
        public boolean loginAction(String email, String password) {

        // création d'une nouvelle demande de connexion
        String url = Statics.BASE_URL + "user/signin"+"?email=" + email +"&password="+password;
        con.setUrl(url);// Insertion de l'URL de notre demande de connexion

        con.addResponseListener((e) -> {
            result = con.getResponseCode() == 200;
            
            if (result) {
                try {
                    
                    parseListUserJson(new String(con.getResponseData()));
                    String str = new String(con.getResponseData());//Récupération de la réponse du serveur
                     System.out.println(str);//Affichage de la réponse serveur sur la console
                    
                } catch (ParseException ex) {

                }
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(con);// Ajout de notre demande de connexion à la file d'attente du NetworkManager
        return result;
    }
    
     public User parseListUserJson(String json) throws ParseException {

        User u = new User();
        try {
            JSONParser j = new JSONParser();

            Map<String, Object> obj = j.parseJSON(new CharArrayReader(json.toCharArray()));
            u.setId_user((int) (double) obj.get("iduser"));
            u.setEmail(obj.get("email").toString());
            if (obj.get("nom") != null) {
                u.setNom(obj.get("nom").toString());
            }
            if (obj.get("prenom") != null) {
                u.setPrenom(obj.get("prenom").toString());
            }

                u.setAge((int) (double)obj.get("age"));



                        if (obj.get("adresse") != null) {
                u.setAdresse(obj.get("adresse").toString());
            }
                        

                                                
                                                            if (obj.get("cin") != null) {
                u.setCin((obj.get("cin").toString()));
            }

         u.setRoles(obj.get("role").toString());

            UserSession z = UserSession.getInstance(u);
             System.out.println("session :" +z.getU().getRoles());

        } catch (IOException ex) {
        }

        return u;
    }
     
     
       public ArrayList<User> parseListtUserJson(String json) {
                try {

            users=new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> tasksListJson = j.parseJSON(new CharArrayReader(json.toCharArray()));
            List<Map<String,Object>> list = (List<Map<String,Object>>)tasksListJson.get("root");
            for(Map<String,Object> obj : list){
                User u = new User();
                                       
            u.setId_user((int) (double) obj.get("iduser"));
            u.setEmail(obj.get("email").toString());
            if (obj.get("nom") != null) {
                u.setNom(obj.get("nom").toString());
            }
            if (obj.get("prenom") != null) {
                u.setPrenom(obj.get("prenom").toString());
            }

                u.setAge((int) (double)obj.get("age"));



                        if (obj.get("adresse") != null) {
                u.setAdresse(obj.get("adresse").toString());
            }
                        

                                                
                                                            if (obj.get("cin") != null) {
                u.setCin((obj.get("cin").toString()));
            }

         u.setRoles(obj.get("role").toString());
                users.add(u);
            }
        } catch (IOException ex) {
            
        }
        return users;
    }
     
         public ArrayList<User> getAllUsers(){
        String url = Statics.BASE_URL+"user/All";
       System.out.print(url);
        con.setUrl(url);
        con.addResponseListener(new com.codename1.ui.events.ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                users = parseListtUserJson(new String(con.getResponseData()));
                con.removeResponseListener(this);
            }
        });
        com.codename1.io.NetworkManager.getInstance().addToQueueAndWait(con);
        return users;
    }
        public boolean updateUser(User user) {
           
            
        String url = Statics.BASE_URL
                + "user/editUser?"
                + "id=" + user.getId_user()
                + "&prenom=" + user.getPrenom()
                + "&nom=" + user.getNom()
                + "&address=" + user.getAdresse()
                + "&cin=" + user.getCin()
                + "&email=" + user.getEmail()
                + "&age=" + user.getAge();  
        System.err.println(user);

        ConnectionRequest req = new ConnectionRequest(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                ResultOK = req.getResponseCode() == 200;
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return ResultOK;
    }

    public boolean delete(int id) {
    String url = Statics.BASE_URL + "user/deletedisUser?id="+id;
            ConnectionRequest req = new ConnectionRequest(url);
    req.setUrl(url);
    req.setHttpMethod("DELETE");
    req.addResponseListener(new ActionListener<NetworkEvent>() {
        @Override
        public void actionPerformed(NetworkEvent evt) {
            ResultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
            req.removeResponseListener(this);
        }
    });
    NetworkManager.getInstance().addToQueueAndWait(req);
    return ResultOK;
    } 
                 public boolean updatepassword(String email ,String m) {
           
            
        String url = Statics.BASE_URL
                + "users/updatepassword?"
                + "email=" + email
                + "&password=" + m;

        
     

        ConnectionRequest req = new ConnectionRequest(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                ResultOK = req.getResponseCode() == 200;
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return ResultOK;
    }
                                  public boolean checkemail(String email) {
           
            
        String url = Statics.BASE_URL
                + "users/checkemail?"
                + "email=" + email;
              

        
     

        ConnectionRequest req = new ConnectionRequest(url);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                     con.removeResponseListener(this);
                ResultOK = req.getResponseCode() == 200;
               
            }
        });
          
        NetworkManager.getInstance().addToQueueAndWait(req);
        return ResultOK;
    }
}
