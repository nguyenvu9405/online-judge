package classes;

import java.io.IOException;
import java.net.Socket;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.Scanner;

import utilities.MyDB;

public class SubmissionProcess implements Runnable 
{
	Socket socket;
	Server server;
	Integer core;
	public static final ThreadLocal<Connection> conn= new ThreadLocal<Connection>() {
		protected Connection initialValue()
		{
			try {
				return MyDB.getIntance().getConnection();
			} catch (SQLException e) {				
				return null;
			}
		}
	};
		
	
	public SubmissionProcess(Socket socket, Server server)
	{
		this.socket = socket;
		this.server = server;
		
	}
	
	@Override
	public void run() {
		Submission sub = null;		
		String sub_id =null,prob_id = null ,user_id = null;
		Integer lang_id = 0; 
		try(Scanner sc = new Scanner(socket.getInputStream()))
		{											
			if (sc.hasNext()) sub_id = sc.next();			
			if (sc.hasNext()) prob_id = sc.next();			
			if (sc.hasNext()) user_id = sc.next();
			if (sc.hasNextInt()) lang_id = sc.nextInt(); 
			if (sub_id==null || prob_id==null || user_id==null || lang_id==0) 
				throw new IOException("Incorrect arguments");
			Problem prob = Problem.getProblem(prob_id);			
			this.core =  this.server.getFreeCore();
			sub = new Submission(sub_id, user_id, prob, lang_id, this.core);
			sub.Score();
			
		} 
		catch (IOException| SQLException e) 
		{		
			if (sub!=null) try { sub.setError(199, "System Error"); } catch (SQLException e1) { System.out.println(e1.getMessage());}
			System.out.println(e.getMessage());
		} 
		finally
		{			
			if (this.socket!=null) try { this.socket.close(); } catch (IOException e) {}
			if (conn.get()!=null) try { conn.get().close(); } catch (SQLException e) {}
			conn.remove();		
			if (sub!=null) sub.close();
			this.server.returnRunningCore(this.core);
			
		}
		
	}
	
}