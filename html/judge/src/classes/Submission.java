package classes;

import java.io.Closeable;
import java.io.File;
import java.io.IOException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.Scanner;
import meta.Dir;


public class Submission implements Closeable{
	public String Id;
	public Problem Prob;
	public String UserId;
	public Integer LangId, Core;
	File RootFolder,CodeFile;
	private Connection conn;
	PreparedStatement ptStatus, ptFinishedStatus, ptResultsUpdate;
	
	public Submission(String id, String userId, Problem prob, Integer langId, Integer core) throws SQLException 
	{				
		this.Id = id;
		this.UserId = userId;
		this.Prob = prob;
		this.LangId = langId;
		this.Core = core;
		RootFolder = Dir.getSubmission(this.Id);
		CodeFile = new File(RootFolder,"submission.cpp");		
		conn = SubmissionProcess.conn.get();
	}
	
	public String getId()
	{
		return this.Id;	
	}		
	
	public void setRunningStatus(int status, int test_num)  throws SQLException
	{
		if (this.ptStatus==null) ptStatus = conn.prepareStatement("UPDATE subs SET `status`=?, `test_num`=? WHERE `id`="+this.getId());
		ptStatus.setInt(1, status);
		ptStatus.setInt(2, test_num);
		ptStatus.executeUpdate();
	}
	
	public void setFinishedStatus(int status, String errors,long time, int mem) throws SQLException
	{ 
		this.ptFinishedStatus = conn.prepareStatement("UPDATE subs SET `status`=?, `errors`=?, `time`=?, `mem`=? WHERE `id`="+this.getId());
		this.ptResultsUpdate = conn.prepareStatement("INSERT INTO results(`user_id`,`problem_id`,`status`) VALUE ("+this.UserId+","+this.Prob.Id+",?) ON DUPLICATE KEY UPDATE `status`=GREATEST(`status`,?)");		
		ptFinishedStatus.setInt(1, status);		
		ptFinishedStatus.setString(2, errors);
		ptFinishedStatus.setLong(3, time);
		ptFinishedStatus.setInt(4, mem);
		ptFinishedStatus.executeUpdate();		
		ptResultsUpdate.setInt(1, status);		
		ptResultsUpdate.setInt(2,status);
		ptResultsUpdate.executeUpdate();		
	}
	
	public void setCompiling() throws SQLException
	{
		this.setRunningStatus(1, 0);
	}
	public void setRunningOnTest(int number) throws SQLException 
	{
		this.setRunningStatus(2, number);
	}
	
	public void setAccepted(int time, int mem) throws SQLException 
	{
		this.setFinishedStatus(200, "", time, mem);
	}
	
	public void setError(int status, String errors) throws SQLException 
	{
		this.setFinishedStatus(status, errors, 0, 0);
	}
	
	public void setWrongAnswer(int test_num) throws SQLException
	{
		this.setFinishedStatus(199 , "Wrong answer on test "+test_num, 0 , 0);
	}
	
	public void Score() throws SQLException
	{		
		Scanner s = null;
		try
		{			
					
			ProcessBuilder pb = new ProcessBuilder("judge",this.RootFolder.getAbsolutePath(),this.Prob.getTestsFolder().getAbsolutePath(), 
													this.Prob.getInputFileName(), this.Prob.getOutputFileName(),this.LangId.toString(),  this.Prob.getTimeLimit().toString(), this.Prob.getMemoryLimitInByte().toString(),
													this.Core.toString()
													
					);
			Process p =  pb.start();			
			s = new Scanner(p.getErrorStream());
			while (s.hasNextInt())
			{
				int status = s.nextInt();			
				if (status==1)
				{
					this.setCompiling();
				}
				else if (status==2)
				{
					int test_num = s.nextInt();
					this.setRunningOnTest(test_num);
				}
				else if (status>99 && status<200)
				{					
					int test_num;
					switch (status)
					{
						case 100:							
							this.setError(100, "Compile errors");
							break;
						case 101:
							test_num = s.nextInt();
							this.setError(101, "Time limit exceeded on test "+test_num);
							break;
						case 102:
							test_num = s.nextInt();
							this.setError(102,"Memory limit exceeded on test "+test_num);
							break;
						case 103:
							test_num = s.nextInt();
							this.setError(103, "Output limit exceeded on test "+test_num);
							break;
						case 197:
							this.setError(197, "System errors");
							break;
						case 198:
							this.setError(198, "Unknown errors");
							break;
						case 199:
							test_num = s.nextInt();
							this.setWrongAnswer(test_num);
							break;
					}
				}
				else if (status==200)
				{
					int time = s.nextInt();
					int mem =  s.nextInt();
					this.setAccepted(time, mem);
				}						
			}
			p.waitFor();
			Thread.sleep(500);
		}		
		catch (IOException e)
		{
			this.setError(197, "System errors");
		}
		catch (Exception e)
		{
			this.setError(197,"System errors");
		}
		finally
		{
			if (s!=null) s.close();
		}
	}

	@Override
	public void close() 
	{
		if (ptStatus!=null)try {ptStatus.close();} catch (SQLException e) {}
		if (ptFinishedStatus!=null)try {ptFinishedStatus.close();} catch (SQLException e) {}
		if (ptResultsUpdate!=null)try {ptResultsUpdate.close();} catch (SQLException e) {}	
	}
	
}
