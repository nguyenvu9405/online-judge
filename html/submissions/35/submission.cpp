#include<iostream>
using namespace std;
int a[50],s=0,n,d1=0,d0=0;
long kt()
{
    d0=0;d1=0;
    for(int t=0;t<n;t++)
    {
        if(a[t]==0) d0++;
        else d1++;
        if(d0<d1) return 0;
    }
    if(d0==d1) return 1; else return 0;
}
void init ()
{
    cin >> n;
}
void tim (int i)
{
    for(int j=0;j<=1;j++)
    {
        a[i]=j;
        if(i==n-1)
        {
            if(kt()==1)
                s++;
        }
        else tim(i+1);
    }
}
int main()
{
    init();
    tim(0);
    cout << s;
    return 0;
}
