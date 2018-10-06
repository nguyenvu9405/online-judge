#include <iostream>
#include <math.h>
using namespace std;

int n,i,res=0;
int a[100000],b[100000],x[100000];

void out()
{
    for (int i=1;i<=n;i++)
        cout<<x[i]<<" ";
    cout<<endl;
}
bool NT(int n)
{
    for (int i=2;i<=sqrt(n);i++)
        if (n%i==0) return false;
    return true;
}
void DQ(int i)
{
    for(int j=2;j<=n;j++)
        if (b[j]==0&&NT(x[i-1]+j))
        {
            b[j]=1;
            x[i]=j;
            if (i<n) DQ(i+1);
            else if (NT(x[1]+x[n])) res+=1;
            b[j]=0;
        }
}
int main()
{
    cin>>n;
    n=n*2;
    for (int i=2; i<=n; i++)
        b[i]=0;
    x[0]=0;
    x[1]=1;
    x[n+1]=1;
    DQ(2);
    cout<<res;
}
