program     phan_tap; //LQDDIV
const   fv = '';
        fr = '';
var     n,m:byte;   sum,kq1,kq2,div_s:int64;   top,top1:longint;
        a:array[0..33]of longint;
        w:array[0..65666]of int64;
        d:array[0..65666]of word;
procedure    read_Data;
  var    f:text;   i:byte;
  begin
          assign(f,fv); reset(f);
          readln(f,n); m:=n div 2; sum:=0;
          for i:=1 to n do
            begin  read(f,a[i]);  sum:=sum+a[i]; end;
          div_s:= sum div 2;
          close(f);
  end;
procedure   attemp(v:int64; i:byte);
  begin
          if i<m then
            begin
                attemp(v,i+1);
                attemp(v+a[i],i+1);
            end
          else
            begin
               inc(top); w[top]:=v;
               inc(top); w[top]:=v+a[i];
            end;
  end;
procedure    quick_sort(l,r:longint);
  var   pivot,tam:int64;   i,j:longint;
  begin
        if l>=r then exit;
        pivot:=w[random(r-l+1)+l];
        i:=l; j:=r;
        repeat
            while w[i]<pivot do inc(i);
            while w[j]>pivot do dec(j);
            if i<=j then
              begin
                  if i<j then
                   begin tam:=w[i]; w[i]:=w[j]; w[j]:=tam; end;
                  inc(i); dec(j);
              end;
        until  i>=j;
        quick_sort(l,j); quick_sort(i,r);
  end;
procedure    check(s:int64;turn:longint);
  begin
         if abs(sum-2*s)=kq1 then begin kq2:=kq2+turn; exit; end;
         if abs(sum-2*s)<kq1 then
                begin
                     kq1:=abs(sum-2*s); kq2:=turn;
                end;
  end;
function     find(s:int64):longint;
  var      dau,cuoi,mid:longint;
  begin
        dau:=0; cuoi:=top1;
        while dau<=cuoi do
          begin
              mid:=(dau+cuoi)div 2;
              if div_s>=w[mid]+s then dau:=mid+1
              else cuoi:=mid-1;
          end;
        find:=cuoi;
  end;
procedure    solve(s:int64);
  var     x:longint;
  begin
          x:=find(s);
          check(s+w[x],d[x]); check(s+w[x+1],d[x+1]);
  end;
procedure    attemp_kq(v:int64;i:byte);
  begin
        if i<n then
            begin
                attemp_kq(v,i+1);
                attemp_kq(v+a[i],i+1);
            end
        else
            begin
                solve(v);
                solve(v+a[i]);
            end;
  end;
procedure   process;
  var   i:longint;
  begin
        top:=0;   top1:=0;  d[1]:=1;
        attemp(0,1);
        quick_sort(1,top);
       for i:=1 to top-1 do
          begin
            if w[i]=w[i+1] then d[i+1]:=d[i]+1
            else
              begin
                 inc(top1); w[top1]:=w[i]; d[top1]:=d[i];
                 d[i+1]:=1;
              end;
          end;
        w[0]:=-100000000000000; d[0]:=1;
        inc(top1); w[top1]:=w[top]; d[top1]:=d[top];
        inc(top1); w[top1]:=10000000000000; d[top1]:=1;
        kq1:=100000000000000;
        attemp_kq(0,m+1);
  end;
procedure   write_result;
  var     f:text;
  begin
          assign(f,fr); rewrite(f);
          writeln(f,kq1,' ',kq2 div 2);
          close(f);
  end;
begin
  read_Data;
  process;
  write_result;
end.