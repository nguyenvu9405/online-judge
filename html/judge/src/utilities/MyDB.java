package utilities;

import java.sql.Connection;
import java.sql.SQLException;

import com.mysql.jdbc.jdbc2.optional.MysqlDataSource;

public class MyDB {
	private MysqlDataSource ds;
	private static MyDB db= null;
	
	public MyDB() 
	{
		ds= new MysqlDataSource();
		ds.setUrl("jdbc:mysql://localhost:3306/oj");
		
	}
	
	public static MyDB getIntance()
	{
		if (db==null) 
			db= new MyDB();
		return db;
	}
	
	public Connection getConnection() throws SQLException 
	{
		return ds.getConnection("root","32199400");
	}
	

	/*public PreparedStatement prepareStatement(String str) 
	{
		PreparedStatement st = null;
		try {
			st = conn.prepareStatement(str);
		} catch (SQLException e) {
			e.printStackTrace();
		}
		return st;
	}*/	
}