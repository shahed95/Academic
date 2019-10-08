/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package officeclient;

import java.awt.BorderLayout;
import java.io.BufferedInputStream;
import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.Socket;
import java.util.Objects;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JFrame;

public class OfficeClient extends JFrame {

    public static TaskTake tasktake = new TaskTake();
    public static welcome welc = new welcome();
    static Socket s;
    static DataInputStream din;
    static DataOutputStream dout;
    static InputStream in;
    static OutputStream output;
    String msgin = "";
    String msgout = "";
    String msgtp = "";
    int tcount = 0;
    int fincnt = 0;
    static int portno;
    static String ipAdr;
    static String fileDirectory = "E:\\";
    static String username ;
    OfficeClient() throws IOException {

        
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setTitle("Office Task Manager");
        this.setLayout(new BorderLayout());
        this.add(welc);
        this.pack();
        this.setVisible(true);
        
        welc.iP.setText(ipAdr);
        welc.pN.setText(Integer.toString(portno));
        tasktake.fD.setText(fileDirectory);
        
        tasktake.tt.setText(tcount + "");
        tasktake.fin.setText(fincnt + "");
        
        
        welc.jButton1.addActionListener(e -> {
        
      
        username = welc.uName.getText();
            
            
        this.remove(welc);
        this.add(tasktake,BorderLayout.CENTER);
        
        this.repaint();
        this.validate();
        this.pack();
        });
        
        
        try {
            s = new Socket(ipAdr, portno);
            din = new DataInputStream(s.getInputStream());
            dout = new DataOutputStream(s.getOutputStream());
        } catch (Exception e) {
        }
        
        tasktake.cFd.addActionListener(e
                -> {
            fileDirectory= tasktake.fD.getText();
        }
        );
        
        
//////////////////////////////////// request approval ////////////////////////////////////
        tasktake.rApproval.addActionListener(e
                -> {
            try {
                dout.writeUTF("request");
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }
            String tno = tasktake.tNo.getText();
//            System.out.print("ok");
            try {                
                dout.writeUTF(tno);
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        );
        
//////////////////////////////////file upload///////////////////////////////////////
        tasktake.fUp.addActionListener(e
                -> {
            try {
                dout.writeUTF("file");
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }
            String msgout="";
            msgout = tasktake.fName.getText();
          
            try {
                dout.writeUTF(msgout);
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }

            
            msgout="";
            
            File myFile = new File(fileDirectory+tasktake.fName.getText());
              byte[] mybytearray = new byte[(int) myFile.length()];
         
          FileInputStream fis = null;
            
            try {
                fis = new FileInputStream(myFile);
            } catch (FileNotFoundException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }
            
        BufferedInputStream bis = new BufferedInputStream(fis);
        
            
            try {
                bis.read(mybytearray, 0, mybytearray.length);
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }

         
        OutputStream os = null;
    
            try {
                os = s.getOutputStream();
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }


            try {
                os.write(mybytearray, 0, mybytearray.length);
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }


            try {
                os.flush();
            } catch (IOException ex) {
                Logger.getLogger(OfficeClient.class.getName()).log(Level.SEVERE, null, ex);
            }

            
        }
        );
        

        while (true) {

            msgtp = din.readUTF();

            if (Objects.equals(msgtp, "Task")) {
                tcount++;
                tasktake.jTArea1.append("( new Task )");
                tasktake.jTArea1.append("task no. " + tcount + " added\n");
                msgin = din.readUTF() + "\n";
                tasktake.tt.setText(tcount + "");
                tasktake.jTextArea2.append(tcount + "." + msgin);
                msgin = "";

                tasktake.jButton1.addActionListener(ea
                        -> {
                    tasktake.jTArea1.setText("");
                }
                );

            } /////////////////////////////approve////////////////////////
            else if (Objects.equals(msgtp, "Approved")) {
                msgin = din.readUTF();
                tasktake.jTArea1.append("( Approved Task )");
                tasktake.jTArea1.append("task no. " + msgin + " approved\n");
                msgin = "";
                fincnt++;
                tasktake.fin.setText(fincnt + "");
            } else {
                
                
                msgin = din.readUTF();
                tasktake.jTArea1.append("New file Added, file = "+ msgin +"\n");
                tasktake.fileList.append(msgin +"\n");
                int bytesRead;
                int current = 0;
                InputStream in = s.getInputStream();
                
                OutputStream output = new FileOutputStream(fileDirectory+msgin);
                
                System.out.print("here1");
                byte[] buffer = new byte[1024];
                
                while ((bytesRead = in.read(buffer)) != -1) {
                    output.write(buffer, 0, bytesRead);
                    break;
                }
                System.out.print("here2");

                
            }
        }

    }

    public static void main(String[] args) throws IOException {
        // TODO code application logic here
        Scanner in = new Scanner(System.in);
        
        ipAdr = "localhost";
        portno = 1234;//in.nextInt();
        
        
        
        OfficeClient oc = new OfficeClient();
    }

}
