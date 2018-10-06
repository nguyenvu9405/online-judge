package classes;

import java.io.File;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import meta.Dir;

public class Problem {
	
	int Id, TimeLimit, MemoryLimit;
	String Code,Title, InputFileName,OutputFileName;
	File RootFolder, TestsFolder;
	
	public static Problem getProblem(String id)  
	{			 
		try(PreparedStatement st = SubmissionProcess.conn.get().prepareStatement("SELECT `id`,`code`,`timelimit`,`memorylimit`,`input_name`,`output_name`, `testcases_ver` FROM problems WHERE id=?"))
		{				
			st.setString(1, id);
			ResultSet res = st.executeQuery();
			res.next();
			Problem prob = new Problem(res.getInt("id"),res.getString("code"),res.getInt("timelimit"),res.getInt("memorylimit"),res.getString("input_name"),res.getString("output_name"), res.getInt("testcases_ver"));
			return prob;
		}
		catch (SQLException e)
		{
			return null;
		}		
	}
	
	public Problem(int Id,String Code, int timelimit, int memorylimit, String input_name, String output_name, int testcases_ver)
	{
		this.Id = Id;
		this.Code = Code;		
		this.TimeLimit = timelimit;
		this.MemoryLimit = memorylimit;
		this.InputFileName = input_name; 
		this.OutputFileName = output_name;
		this.RootFolder = new File(Dir.getProblems(), Integer.toString(this.Id));
		this.TestsFolder = new File(RootFolder,"tests_"+testcases_ver);
	}
	
	public int getId() {
		return Id;
	}

	public void setId(int id) {
		Id = id;
	}

	public Integer getTimeLimit() {
		return TimeLimit;
	}	
	
	public void setTimeLimit(int timeLimit) {
		TimeLimit = timeLimit;
	}

	public int getMemoryLimit() {
		return MemoryLimit;
	}
	
	public Integer getMemoryLimitInByte() {
		return MemoryLimit*1024*1024;
	}
	
	public void setMemoryLimit(int memoryLimit) {
		MemoryLimit = memoryLimit;
	}

	public String getCode() {
		return Code;
	}

	public void setCode(String code) {
		Code = code;
	}

	public String getTitle() {
		return Title;
	}

	public void setTitle(String title) {
		Title = title;
	}

	public String getInputFileName() {
		return InputFileName;
	}

	public void setInputFileName(String inputFileName) {
		InputFileName = inputFileName;
	}

	public String getOutputFileName() {
		return OutputFileName;
	}

	public void setOutputFileName(String outputFileName) {
		OutputFileName = outputFileName;
	}

	public File getRootFolder() {
		return RootFolder;
	}

	public void setRootFolder(File rootFolder) {
		RootFolder = rootFolder;
	}

	public File getTestsFolder() {
		return TestsFolder;
	}

	public void setTestsFolder(File testsFolder) {
		TestsFolder = testsFolder;
	}	
}
