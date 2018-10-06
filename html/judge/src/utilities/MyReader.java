package utilities;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.StringTokenizer;

public class MyReader {
	
	public BufferedReader reader;
	public StringTokenizer tokenizer;	
	public MyReader(File src)
	{		
		try {
			this.reader = new BufferedReader(new FileReader(src));
			
		} catch (FileNotFoundException e) {		
			e.printStackTrace();
		}		
	}
	
	public MyReader(InputStream src)
	{		
		this.reader = new BufferedReader(new InputStreamReader(src));		
	}
	
	public boolean hasMoreTokens()throws IOException
	{
		if (tokenizer==null || !tokenizer.hasMoreTokens())
		{
			String line = null;
			while ((line=reader.readLine()) !=null)
			{							
				tokenizer = new StringTokenizer(line);
				if (tokenizer.hasMoreTokens()) return true;
			}					
		}	
		else return true;
		
		return false;
	}
	
	public String nextToken() throws IOException
	{						
		if (this.hasMoreTokens()) return tokenizer.nextToken();
		else return null;
	}	

	public String readNextLine() throws IOException
	{
		return reader.readLine();
	}
}

