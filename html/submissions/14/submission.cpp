Program DAYNGO;
Var
  n :Byte;
  res :Int64;
  X :String;
  D :Array['('..')'] of Byte;

  procedure Enter;
  var
    i :Byte;
  begin
    ReadLn(n); X:=''; res:=0;
    for i:=1 to n do X:=X+' ';
    D['(']:=0; D[')']:=0;
  end;

  procedure Back(i :Byte);
  var
    j :Char;
  begin
    for j:='(' to ')' do
      if (D[j]+1<=n div 2) then
        begin
          Inc(D[j]); X[i]:=j;
          if (D['(']>=D[')']) then
	    	begin
              if (i=n) then
                begin
                  Inc(res); //WriteLn(X);
                end
              else Back(i+1);
		    end;
          Dec(D[j]);
        end;
  end;

Begin
  Enter;
  Back(1);
  Write(res);
End.
