package meta;

import java.io.File;

public class Dir {	
	public static File Root = new File("/var/www/html/");
	public static File Problems = new File(Root, "problems-storage");
	public static File Submissions = new File(Root, "submissions");
	
	public static File getRoot()
	{
		return Root;
	}
	
	public static File getSubmissions()
	{
		return Submissions;
	}
	
	public static File getSubmission(String id)
	{
		return new File(getSubmissions(),id);
	}
		
	public static File getProblems()
	{
		return Problems;
	}
}
