package classes;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.SocketException;
import java.util.concurrent.Executor;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.RejectedExecutionException;
import java.util.concurrent.TimeUnit;

import judge.main;

public class Server implements Runnable {
	
	ExecutorService threadPool = null;
	ServerSocket serverSocket = null;
	private volatile boolean usedCore[];

	public Server()
	{		
		usedCore = new boolean[2];
		for (int i=0; i<2; i++)
		{
			usedCore[i] = false;
		}
	}
	
	public Integer getFreeCore()
	{	
		for (int i=0; i<2; i++)
		if (!usedCore[i])
		{
			usedCore[i]=true;
			return i;
		}		
		return 0;
	}
	
	public void returnRunningCore(Integer num)
	{
		usedCore[num] = false;
	}
	
	@Override
	public void run() {
		
		try
		{		
			ProcessBuilder pb = new ProcessBuilder("cpupower","-c","2-3","frequency-set","-g", "performance");
			Process p =  pb.start();	
			p.waitFor();
			pb = new ProcessBuilder("cpupower","-c","2-3","frequency-set","-u", "2400MHz");
			p =  pb.start();	
			p.waitFor();
			serverSocket = new ServerSocket(1111);
			threadPool= Executors.newFixedThreadPool(2);				
			main.write("The judger is running");
			while (true)
			{
				SubmissionProcess process = new SubmissionProcess(serverSocket.accept(),this);
				threadPool.execute(process);					
			}
			
		}
		catch (SocketException | RejectedExecutionException e)
		{
			try {
				if (threadPool.awaitTermination(1, TimeUnit.MINUTES)) main.write("Successfully stopped");
			} catch (InterruptedException e1) {
				main.write("Time out. It couldn't be stopped");
			}		
		}
		catch (IOException e) {			
			main.write("Cannot create the server socket: "+e.getMessage());
			return;
		} catch (InterruptedException e) {			
			main.write("Cannot create the server socket: "+e.getMessage());
			return;
		}		
		finally 
		{
			if (serverSocket!=null && !serverSocket.isClosed())
			{
				try {
					serverSocket.close();
				} catch (IOException e) {
					e.printStackTrace();
				}
			}
		}
	}
	
	
	public void stop()
	{
		try
		{
			if (threadPool!=null)  { threadPool.shutdown(); }
			if (serverSocket!=null) { serverSocket.close(); }				
			main.write("The judger is being stopped");					
		}
		catch (IOException e)
		{
			main.write("The judger couldn't be stopped");						
		}				
	}

}
