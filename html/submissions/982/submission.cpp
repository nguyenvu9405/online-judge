{$+R,+Q}
program LQDDIV;
type re=record
     ts:int64;
     s:longint;
     end;
const fi='';
      fo='';
type tlist=array[0..65536] of int64;
var f1,f2:text;
    s1,s2:array[0..65536] of int64;
    dem2,dem3,dem4,dem5:longint;
    n:longint;
    min,f:int64;
    b,c:array[0..65536] of re;
    tong2,tong:int64;
    a:array[1..32] of longint;
procedure Mo;
begin
assign(f1,fi);
reset(f1);
assign(F2,fo);
rewrite(f2);
end;

procedure Dong;
begin
close(f1);
close(f2);
end;

procedure sort(var b:tlist;l,h:longint);
  procedure quicksort(l,h:longint);
   var i,j:longint;
     tg,p:int64;
   begin
   if l>=h then exit;
   i:=l; j:=h; p:=b[(l+h) div 2];
   repeat
   while b[i] > p do inc(i);
   while b[j] < p do dec(j);
   if i <= j then
   begin
   tg:=b[i];
   b[i]:=b[j];
   b[j]:=tg;
   inc(i); dec(j);
   end;
   until i>j;
   quicksort(l,j);
   quicksort(i,h);
  end;
begin
quicksort(l,h);
end;

procedure sinh1(j:integer);
var i:integer;
begin
inc(dem2);s1[dem2]:=tong;
for i:=j to n div 2 do
 begin
  tong:=tong+a[i];
  sinh1(i+1);
  tong:=tong-a[i];
 end;
end;

procedure sinh2(j:integer);
var i:integer;
begin
inc(dem3);s2[dem3]:=tong;
for i:=j to n  do
 begin
  tong:=tong+a[i];
  sinh2(i+1);
  tong:=tong-a[i];
 end;
end;

procedure nhap;
var i,j,f4,f3:longint;
begin
readln(f1,n);
for i:=1 to n do
begin
 read(f1,a[i]);
 tong2:=tong2+a[i];
end;
sinh1(1);
sinh2(n div 2 +1);
sort(s1,1,dem2);
sort(s2,1,dem3);
min:=high(int64);
for i:=1 to dem2 do
 if s1[i]<>b[dem4].ts then begin inc(dem4);b[dem4].ts:=s1[i];inc(b[dem4].s); end
 else inc(b[dem4].s);
for i:=1 to dem3 do
 if s2[i]<>c[dem5].ts then begin inc(dem5);c[dem5].ts:=s2[i];inc(c[dem5].s) end
 else inc(c[dem5].s);

j:=dem5;
for i:=1 to dem4 do
 begin
  while (2*(b[i].ts+c[j].ts) < tong2) and (j>1) do dec(j);
  if 2*(b[i].ts+c[j].ts) >=tong2 then
  if 2*(b[i].ts+c[j].ts) <min then
   begin
    min:=2*(b[i].ts+c[j].ts);
    f:=b[i].s*c[j].s;
   end
  else if 2*(b[i].ts+c[j].ts) = min
   then f:=f+b[i].s*c[j].s;
  end;
if min-tong2=0 then  f:=f div 2;
writeln(f2,min-tong2,' ',f);
end;

BEGIN
mo;
nhap;
dong;
END.
