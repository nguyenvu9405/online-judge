#include<bits/stdc++.h>
using namespace std;
long long n,a[31];
void nhap()
{
    cin >> n;
}
bool check()
{
    int d0=0,d1=0;
    for(int i=1;i<=n;i++)
    {
        if(a[i]==0)d0++;
        else  d1++;
        if(d0<d1) return false;
    }
    if(d0!=d1) return false;
    return true;
}
void xuat()
{
    for(int i=1;i<=n;i++)
        cout<<a[i];
        cout<<endl;
}
void hamchinh(int i)
{
    for(int j=0;j<=1;j++)
    {
       a[i]=j;
       if (i==n)
       {
           if(check()) xuat();
       }
       else hamchinh(i+1);

    }
}
int main()
{
nhap();
hamchinh(1);
}



