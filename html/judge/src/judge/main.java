package judge;

import java.util.Scanner;
import classes.Server;


public class main {
	public static boolean running = false;	
	public static void write(String msg)
	{
		System.out.println("Log: "+msg);
	}
	
	public static void main(String[] args) {		
		Scanner sc = new Scanner(System.in);
		Server sv = null;
		while (true)
		{
			String cmd = sc.nextLine().trim();
			if (cmd.equals("start"))
			{
				if (running==false)
				{					
					sv = new Server();
					Thread serverThread = new Thread(sv);
					serverThread.start();
					running = true;
				}
				else				
				{
					main.write("The judger is already running");
				}
				
			}
			if (cmd.equals("stop"))
			{
				if (running==true)
				{					
					sv.stop();				
				}
				else					
				{
					main.write("The judger is already stopped");
				}
			}
			if (cmd.equals("quit")) break;		
		}
		if (sc!=null) sc.close();		
	}
	
		
}
