/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package officeserver;

import java.awt.BorderLayout;
import static java.awt.SystemColor.menu;
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
import static java.lang.System.in;
import static java.lang.System.out;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JFrame;

/**
 *
 * @author Shahed Ahmed
 */
public class OfficeServer extends JFrame {

    /**
     * @param args the command line arguments
     */
    public static TaskAdd taskadd = new TaskAdd();
    public static welcome welc = new welcome();
    static ServerSocket ss;
    static Socket s;
    static DataInputStream din;
    static DataOutputStream dout;
    static FileInputStream fis;
    static BufferedInputStream bis;
    static OutputStream os;
    static int portno=6666;
    public int[] waiting = new int[50];
    static String fileDirectory="D:\\";
    OfficeServer() throws IOException {
        
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setTitle("Office Task Manager");
        this.setLayout(new BorderLayout());
        this.add(welc);
        this.pack();
        this.setVisible(true);
        
        
        welc.pN.setText(Integer.toString(portno));
        
        welc.jButton1.addActionListener(e -> {
        taskadd.fD.setText(fileDirectory);
//        portno = welc.jTextField1.getText();
        
        this.remove(welc);
        this.add(taskadd,BorderLayout.CENTER);
        
        this.repaint();
        this.validate();
        this.pack();
        });
        
        
        taskadd.cFd.addActionListener(e
                -> {
            fileDirectory= taskadd.fD.getText();
        }
        );
        
        
        
        try {
            ss = new ServerSocket(portno);
            s = ss.accept();

            din = new DataInputStream(s.getInputStream());
            dout = new DataOutputStream(s.getOutputStream());
            
        } catch (Exception e) {
        }
        
   
        
        //////////////////// task////////////////////
        
        taskadd.jButton1.addActionListener(e
                -> {
            String msgout = "";

            try {
                dout.writeUTF("Task");
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }

            msgout = taskadd.jTF1.getText().trim();
            try {
                dout.writeUTF(msgout);
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }

        }
        );
        ////////////////////////////////// 
        taskadd.approve.addActionListener(e
                -> {
            String msgout = "";

            try {
                dout.writeUTF("Approved");
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }

            msgout = taskadd.aTask.getText().trim();
            try {
                dout.writeUTF(msgout);
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
            waiting[Integer.parseInt(msgout)]=0;
            taskadd.tWait.setText("");
                    for(int i=0;i<30;i++)
                    {
                        if(waiting[i]==1)
                        {
                           taskadd.tWait.append("task no. "+i+" is waiting for approval\n"); 
                        }
                    }

        }
        );
        
        
       
        
        
        taskadd.jUp.addActionListener(e
                -> {
            String msgout = "";

            try {
                dout.writeUTF("File");
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
            
            msgout = taskadd.fName.getText();
            
            try {
                dout.writeUTF(msgout);
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
            msgout="";
            
            File myFile = new File(fileDirectory+taskadd.fName.getText());
              byte[] mybytearray = new byte[(int) myFile.length()];
         
        FileInputStream fis = null;
            try {
                fis = new FileInputStream(myFile);
            } catch (FileNotFoundException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
        BufferedInputStream bis = new BufferedInputStream(fis);
        
            try {
                bis.read(mybytearray, 0, mybytearray.length);
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName(
                )).log(Level.SEVERE, null, ex);
            }
         
        OutputStream os = null;
            try {
                os = s.getOutputStream();
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                os.write(mybytearray, 0, mybytearray.length);
            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                os.flush();

            } catch (IOException ex) {
                Logger.getLogger(OfficeServer.class.getName()).log(Level.SEVERE, null, ex);
            }
    //        sock.close();
            
        }
                
        );
        
        while (true) {
                String msgtp="",msgin="";
                msgtp = din.readUTF(); 
                
                if(msgtp.equals("request")) {
                    msgin = din.readUTF();
//                    taskadd.tWait.append(msgin);
                    waiting[Integer.parseInt(msgin)]=1;
                    
                    taskadd.tWait.setText("");
                    for(int i=0;i<30;i++)
                    {
                        if(waiting[i]==1)
                        {
                           taskadd.tWait.append("task no. "+i+" is waiting for approval\n"); 
                        }
                    }
                }
                
                if(msgtp.equals("user")) {
                    msgin = din.readUTF();
//                    taskadd.cW.append(msgin);
                
                }
                
                
                if(msgtp.equals("file")) {
                    msgin = din.readUTF();
//                tasktake.jTArea1.append("New file Added, file = "+ msgin +"\n");
                taskadd.fileList.append(msgin +"\n");
                int bytesRead;
                int current = 0;
                InputStream in = s.getInputStream();
                
                OutputStream output = new FileOutputStream(fileDirectory+msgin);
                
                System.out.print("here1");
                byte[] buffer = new byte[1024*1024];
                
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
        portno = 1234;//in.nextInt();
        OfficeServer os = new OfficeServer();
    }

}
